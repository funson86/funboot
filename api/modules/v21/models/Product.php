<?php

namespace api\modules\v21\models;

/**
 * Class Product
 * @package api\models\food
 * @author funson86 <funson86@gmail.com>
 */
class Product extends \common\models\mall\Product
{
    public function fields()
    {
        return [
            'id', 'store_id', 'name', 'sku', 'price', 'thumb',
        ];
    }
}
