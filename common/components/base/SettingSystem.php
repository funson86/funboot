<?php

namespace common\components\base;

use common\helpers\ArrayHelper;
use common\models\base\DictData;
use common\models\base\SettingType;
use common\models\Store;
use Yii;
use common\models\base\Dict;

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