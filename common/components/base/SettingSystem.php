<?php

namespace common\components\base;

use common\helpers\ArrayHelper;
use common\models\base\DictData;
use common\models\base\Setting;
use common\models\base\SettingType;
use common\models\Store;
use Yii;
use common\models\base\Dict;
use yii\helpers\Json;

/**
 * Class SettingSystem
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class SettingSystem extends \yii\base\Component
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function getValue($code, $storeId)
    {
        $settingTypes = Yii::$app->cacheSystem->getStoreSetting($storeId);

        foreach ($settingTypes as $settingType) {
            if ($settingType['code'] == $code) {
                if (isset($settingType['setting']['value'])) {
                    return $settingType['setting']['value'];
                } else {
                    return $settingType['value_default'];
                }
            }
        }

        return null;
    }

    public function setValue($code, $value, $storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();

        $settingType = SettingType::find()->where(['code' => $code])->one();
        if (!$settingType) {
            return false;
        }

        $model = Setting::find()->where(['code' => $code, 'store_id' => $storeId])->one();
        if (!$model) {
            $model = new Setting();
            $model->store_id = $storeId;
            $model->app_id = Yii::$app->id;
            $model->name = $settingType->name;
            $model->setting_type_id = $settingType->id;
            $model->code = $code;
        }
        $model->value = is_array($value) ? Json::encode($value) : trim($value);
        if ($model->save()) {
            Yii::$app->cacheSystem->clearStoreSetting($storeId);
            return true;
        }

        return false;
    }

    public function getSettings($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        $settingTypes = Yii::$app->cacheSystem->getStoreSetting($storeId);

        $settings = [];
        foreach ($settingTypes as $settingType) {
            $settings[$settingType['code']] =  $settingType['setting']['value'] ?? $settingType['value_default'];
        }

        return $settings;
    }

    /**
     * 清除cache
     * @param $storeId
     * @return bool
     */
    public function clearStoreCache($storeId)
    {
        return Yii::$app->cacheSystem->clearStoreSetting($storeId);
    }

    /**
     * 清除cache
     * @return bool
     */
    public function clearCache()
    {
        return Yii::$app->cacheSystem->clearAllSetting();
    }
}