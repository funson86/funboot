<?php

namespace common\services\mall;

use common\models\mall\Product;
use common\models\Store;
use Yii;
use yii\base\Model;

/**
 * Class ProductService
 * @package common\services\mall
 * @author funson86 <funson86@gmail.com>
 */
class ProductService extends BaseService
{
    public static function convertList(array &$models)
    {
        foreach ($models as &$model) {
            $model['name'] = fbt(Product::getTableCode(), $model['id'], 'name', $model['name']);
            $model['type_'] = Product::getTypesLabel($model['type']);
            $model['currency'] = self::getCurrentCurrency();
            $model['currency_'] = Store::getCurrencyShortName(self::getCurrentCurrency(), true, true);
        }

        return $models;
    }
}
