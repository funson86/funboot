<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use common\helpers\IdHelper;
use common\models\base\SettingType;
use Yii;
use common\models\base\Setting;
use common\models\ModelSearch;
use backend\controllers\BaseController;
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
     * 可编辑字段
     *
     * @var int
     */
    protected $exportFields = [
        'id' => 'text',
        'name' => 'text',
        'type' => 'select',
    ];

    /**
      * 列表页
      *
      * @return string
      * @throws \yii\web\NotFoundHttpException
      */
    /*public function actionIndex()
    {
        $searchModel = new ModelSearch([
            'model' => $this->modelClass,
            'scenario' => 'default',
            'likeAttributes' => $this->likeAttributes,
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        // 管理员级别才能查看所有数据，其他只能查看本store数据
        $params = Yii::$app->request->queryParams;
        if (!$this->isAdmin()) {
            $params['ModelSearch']['store_id'] = $this->getStoreId();
        }
        $dataProvider = $searchModel->search($params);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }*/

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
                $model->value = is_array($value) ? Json::encode($value) : $value;

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

}
