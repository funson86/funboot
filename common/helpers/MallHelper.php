<?php

namespace common\helpers;
use Yii;

/**
 * Class MallHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class MallHelper
{
    public static function getCurrentCurrency()
    {
        return Yii::$app->session->get('currentCurrency', Yii::$app->settingSystem->getValue('mall_currency_default'));
    }

    public static function getCurrentCurrencySymbol()
    {
        $currencies = json_decode(Yii::$app->settingSystem->getValue('mall_currencies'), true);
        $mapCurrency = ArrayHelper::map($currencies, 'code', 'symbol');
        return $mapCurrency[static::getCurrentCurrency()] ?? '$';
    }

    public static function getCurrentCurrencyRate()
    {
        $currencies = json_decode(Yii::$app->settingSystem->getValue('mall_currencies'), true);
        $mapCurrency = ArrayHelper::map($currencies, 'code', 'rate');
        return $mapCurrency[static::getCurrentCurrency()] ?? 1;
    }

    public static function getNumberByCurrency($number, $decimals = 2, $currencyLabel = true, $raw = false)
    {
        return ($currencyLabel ? static::getCurrentCurrencySymbol() : '') . number_format(($raw ? $number : $number * static::getCurrentCurrencyRate()), $decimals);
    }

}
