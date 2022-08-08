<?php

namespace common\services\mall;

use Yii;

/**
 * Class BaseService
 * @package common\services\mall
 * @author funson86 <funson86@gmail.com>
 */
class BaseService extends \common\services\BaseService
{
    public static function getCurrentCurrency()
    {
        return Yii::$app->session->get('currentCurrency', Yii::$app->settingSystem->getValue('mall_currency_default'));
    }
}
