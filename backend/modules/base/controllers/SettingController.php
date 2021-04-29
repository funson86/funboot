<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use common\helpers\IdHelper;
use common\helpers\OfficeHelper;
use common\models\base\SettingType;
use Yii;
use common\models\base\Setting;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\helpers\Json;

/**
 * Setting
 *
 * Class SettingController
 * @package backend\modules\base\controllers
 */
class SettingController extends BaseController
{
    /**
      * @var Setting
      */
    public $modelClass = Setting::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name'];

    /**
     * 可编辑字段
     *
     * @var int
     */
    protected $editAjaxFields = ['name', 'sort'];

    /**
     * 导入导出字段
     *
     * @var int
     */
    protected $exportFields = [
        'id' => 'text',
        'code' => 'text',
        'value' => 'text',
    ];

    protected $exportSort = ['store_id' => SORT_ASC, 'setting_type_id' => SORT_DESC];

    /**
      * ajax编辑/创建
      *
      * @return mixed|string|\yii\web\Response
      * @throws \yii\base\ExitException
      */
    public function actionEditAll()
    {
        $settingTypes = SettingType::find()->where(['status' => SettingType::STATUS_ACTIVE])
            ->with(['setting' => function ($query) {
                $query->andWhere(['store_id' => $this->getStoreId()]);
            }])
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])
            ->asArray()
            ->all();

        return $this->render($this->action->id, [
            'settingTypes' => ArrayHelper::tree($settingTypes),
        ]);
    }

    /**
      * ajax编辑/创建
      *
      * @return mixed|string|\yii\web\Response
      * @throws \yii\base\ExitException
      */
    public function actionEditAjaxSave()
    {
        $settingTypes = SettingType::find()->all();
        $mapSettingTypeCodeName = ArrayHelper::map($settingTypes, 'code', 'name');
        $mapSettingTypeCodeId = ArrayHelper::map($settingTypes, 'code', 'id');

        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            $setting = Yii::$app->request->post('setting', []);

            foreach ($setting as $code => $value) {
                if (!$mapSettingTypeCodeId[$code]) {
                    Yii::$app->logSystem->db($setting);
                    return $this->error(Yii::t('app', 'Invalid code'));
                }

                $model = $this->findModelByField($code, 'code');
                $model->app_id = Yii::$app->id;
                $model->name = $mapSettingTypeCodeName[$code] ?? '';
                $model->setting_type_id = $mapSettingTypeCodeId[$code] ?? '';
                $model->code = $code;
                $model->value = is_array($value) ? Json::encode($value) : trim($value);

                if (!$model->save()) {
                    Yii::$app->logSystem->db($model->errors);
                    return $this->error();
                }
            }

            Yii::$app->cacheSystem->clearStoreSetting($this->getStoreId());
            return $this->success();
        }


        return $this->error();
    }

    /**
     * 返回模型
     *
     * @param $value
     * @param string $field
     * @param bool $highConcurrency
     * @return \yii\db\ActiveRecord
     * @throws \Exception
     */
    protected function findModelByField($value, $field = 'name', $highConcurrency = false)
    {
        /* @var $model \yii\db\ActiveRecord */
        $storeId = $this->getStoreId();
        if ((empty(($model = $this->modelClass::find()->where([$field => $value])->andFilterWhere(['store_id' => $storeId])->one())))) {
            $model = new $this->modelClass();
            $model->loadDefaultValues();

            if ($highConcurrency) {
                $model->id = IdHelper::snowFlakeId();
            }

            if (isset($model->store_id)) {
                $model->store_id = $this->getStoreId();
            }

            return $model;
        }

        return $model;
    }

    protected function beforeImport($model = null)
    {
        $model->setting_type_id = 1001;
    }

    public function actionImportRepairSettingType()
    {
        if (!$this->isAdmin()) {
            return $this->goBack();
        }

        $settingTypes = SettingType::find()->all();
        $mapCodeId = ArrayHelper::map($settingTypes, 'code', 'id');
        $mapCodeName = ArrayHelper::map($settingTypes, 'code', 'name');

        Setting::updateAll(['status' => Setting::STATUS_DELETED]);
        $models = Setting::find()->all();
        foreach ($models as $model) {
            Setting::deleteAll(['and', ['store_id' => $model->store_id, 'code' => $model->code], 'id < ' . $model->id]);
            Setting::updateAll(['setting_type_id' => ($mapCodeId[$model->code] ?? 1001)], ['id' => $model->id]);
            Setting::updateAll(['name' => ($mapCodeName[$model->code] ?? '')], ['id' => $model->id]);
        }

        return $this->redirectSuccess(Yii::$app->request->referrer);
    }

    /**
     * 导出所有站点的数据
     * @return mixed
     */
    public function actionExportAll()
    {
        if (!$this->isAdmin()) {
            return $this->goBack();
        }

        $codes = ['store_id', 'website_name', 'website_logo'];

        $fields = [];
        foreach ($codes as $k => $code) {
            $item = [$code, $code, 'text'];
            $fields[] = $item;
        }


        $ext = Yii::$app->request->get('ext', 'xls');
        $storeId = $this->isAdmin() ? null : $this->getStoreId();

        $models = [];
        $settings = $this->modelClass::find()->orderBy($this->exportSort)->asArray()->all();
        foreach ($settings as $setting) {
            if (!isset($models[$setting['store_id']])) {
                $models[$setting['store_id']] = [];
                $models[$setting['store_id']]['store_id'] = $setting['store_id'];
            }
            $models[$setting['store_id']][$setting['code']] = $setting['value'];
        }
        //var_dump($models);

        $spreadSheet = $this->arrayToSheet($models, $fields);//vd($spreadSheet);

        $arrModelClass = explode('\\', strtolower($this->modelClass));
        OfficeHelper::write($spreadSheet, $ext, 'settings_' . array_pop($arrModelClass) . '_' . date('mdHis') . '.' . $ext);

        exit();

        return $this->redirectSuccess(Yii::$app->request->referrer);
    }
}
