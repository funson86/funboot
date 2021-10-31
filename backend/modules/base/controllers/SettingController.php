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
        // 'id' => 'text',
        'code' => 'text',
        'value' => 'text',
    ];

    protected $exportSort = ['store_id' => SORT_ASC, 'setting_type_id' => SORT_ASC];

    /**
      * ajax编辑/创建
      *
      * @return mixed|string|\yii\web\Response
      * @throws \yii\base\ExitException
      */
    public function actionEditAll()
    {
        $storeId = Yii::$app->request->get('store_id', $this->getStoreId());
        $settingTypes = SettingType::find()->where(['status' => SettingType::STATUS_ACTIVE])
            ->andWhere('support_role & ' . Yii::$app->authSystem->getRoleCode() . ' = ' . Yii::$app->authSystem->getRoleCode())
            ->andWhere(['or', 'support_system & 1 = 1', 'support_system & ' . Yii::$app->storeSystem->getRouteCode() . ' = ' .Yii::$app->storeSystem->getRouteCode()])
            ->with(['setting' => function ($query) use ($storeId) {
                $query->andWhere(['store_id' => $storeId]);
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
                $model->store_id = Yii::$app->request->get('store_id', $this->getStoreId());
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
            $this->afterEditAjaxSave($setting);

            Yii::$app->cacheSystem->clearStoreSetting($this->getStoreId());
            return $this->success();
        }


        return $this->error();
    }

    /**
     * @param $setting
     */
    protected function afterEditAjaxSave($setting)
    {
        foreach ($setting as $code => $value) { // 根据code自定义规则
        }
    }

    /**
     * 返回模型
     *
     * @param $value
     * @param string $field
     * @return \yii\db\ActiveRecord
     * @throws \Exception
     */
    protected function findModelByField($value, $field = 'name')
    {
        /* @var $model \yii\db\ActiveRecord */
        $storeId = $this->getStoreId();
        if ((empty(($model = $this->modelClass::find()->where([$field => $value])->andFilterWhere(['store_id' => $storeId])->one())))) {
            $model = new $this->modelClass();
            $model->loadDefaultValues();

            return $model;
        }

        return $model;
    }


    /**
     * 导入
     *
     * @return mixed
     */
    public function actionImportAjax()
    {
        $settingTypes = SettingType::find()->all();
        $mapCodeId = ArrayHelper::map($settingTypes, 'code', 'id');
        $mapCodeName = ArrayHelper::map($settingTypes, 'code', 'name');
        if (Yii::$app->request->isPost) {
            try {
                $file = $_FILES['importFile'];
                $data = OfficeHelper::readExcel($file['tmp_name'], 1);
                $count = count($data);

                $countCreate = $countUpdate = 0;
                $errorLines = $errorMsgs = [];
                for ($i = 2; $i <= $count; $i++) { // 忽略第1行表头
                    $row = $data[$i];

                    $code = trim($row[0]);
                    if (!isset($mapCodeId[$code])) {
                        continue;
                    }

                    // 更新的话ID必须在第一行，有数据才查找
                    if (isset($row[0]) && strlen($row[0]) > 0) {
                        $model = $this->modelClass::find()->where(['store_id' => $this->getStoreId(), 'code' => $row[0]])->one();
                        if (!$model) {
                            $model = new $this->modelClass();
                            $model->code = trim($row[0]);
                        }
                    }

                    $j = 0;
                    $errorData = false;
                    $model->value = trim($row[1]);
                    $model->setting_type_id = $mapCodeId[$code] ?? 1001;
                    $model->name = $mapCodeName[$code] ?? 'tmp';

                    //数据无错误才插入
                    if (!$errorData) {
                        $this->beforeImport($model);
                        if (!$model->save()) {
                            array_push($errorLines, $i);
                            array_push($errorMsgs, json_encode($model->errors));
                        }
                        $this->afterImport($model);
                        $countCreate++;
                    }

                    if (count($errorLines)) {
                        $strLine = implode(', ', $errorLines);
                        $strMsg = implode(', ', $errorMsgs);
                        $this->flashError(Yii::t('app', "Line {strLine} error.", ['strLine' => $strLine . $strMsg]));
                    }

                    $this->flashSuccess(Yii::t('app', "Import Data Success. Create: {countCreate}  Update: {countUpdate}", ['countCreate' => $countCreate, 'countUpdate' => $countUpdate]));
                }


            } catch (\Exception $e) {
                return $this->redirectError($e->getMessage(), null, true);
            }

            Yii::$app->cacheSystem->clearStoreSetting();
            return $this->redirectSuccess();
        }

        return $this->renderAjax('@backend/views/site/' . $this->action->id);
    }

    /**
     * 删除重复的，根据code重新修复setting_type_id，根据code重新修复name
     * @return mixed|\yii\web\Response
     */
    public function actionImportRepairSettingType()
    {
        if (!$this->isAdmin()) {
            return $this->goBack();
        }

        $settingTypes = SettingType::find()->all();
        $mapCodeId = ArrayHelper::map($settingTypes, 'code', 'id');
        $mapCodeName = ArrayHelper::map($settingTypes, 'code', 'name');

        $models = Setting::find()->all();
        foreach ($models as $model) {
            Setting::deleteAll(['and', ['store_id' => $model->store_id, 'code' => $model->code], 'id < ' . $model->id]);
            Setting::updateAll(['setting_type_id' => ($mapCodeId[$model->code] ?? 1001)], ['id' => $model->id]);
            Setting::updateAll(['name' => ($mapCodeName[$model->code] ?? '')], ['id' => $model->id]);
        }

        Yii::$app->cacheSystem->clearStoreSetting();
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

        $codes = ['store_id'];//, 'website_name', 'contact_email', 'payment_publish_key', 'printer_code', 'website_logo'];
        $codes = ArrayHelper::merge($codes, ArrayHelper::getColumn(SettingType::find()->all(), 'code'));

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

        $models = array_values($models);
        $spreadSheet = $this->arrayToSheet($models, $fields);

        $arrModelClass = explode('\\', strtolower($this->modelClass));
        OfficeHelper::write($spreadSheet, $ext, 'settings_' . array_pop($arrModelClass) . '_' . date('mdHis') . '.' . $ext);

        exit();
    }

    public function actionEditAjaxCodeValue()
    {
        $code = Yii::$app->request->get('code');
        $value = Yii::$app->request->get('value');

        if (!$code || is_null($value)) {
            return $this->error();
        }

        $settingType = SettingType::findOne(['code' => $code]);
        if (!$settingType) {
            return $this->error();
        }

        $model = Setting::find()->where(['store_id' => $this->store->id, 'code' => $code])->one();
        if (!$model) {
            $model = $this->findModelByField($code, 'code');
            $model->app_id = Yii::$app->id;
            $model->name = $settingType->name;
            $model->setting_type_id = $settingType->id;
            $model->code = $code;
        }
        $model->value = is_array($value) ? Json::encode($value) : $value;

        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return $this->error();
        }
        $this->afterEditAjaxSave([$code => $value]);

        Yii::$app->cacheSystem->clearStoreSetting($this->store->id);
        return $this->success();
    }

    public function actionEditQuick()
    {
        return $this->render($this->action->id);
    }
}
