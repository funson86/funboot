<?php

namespace api\modules\v21\models;

use common\helpers\ImageHelper;
use common\helpers\MallHelper;
use Yii;

/**
 * Class Favorite
 * @package api\modules\v21\models
 * @author funson86 <funson86@gmail.com>
 */
class Favorite extends \common\models\mall\Favorite
{
    public function fields()
    {
        return [
            'id', 'store_id', 'name', 'product_id', 'price_', 'created_at',
            'name_', 'thumb_', 'brief_', 'currency_',
        ];
    }

    public function getName_()
    {
        return fbt(Product::$tableCode, $this->product_id, 'name', $this->name);
    }

    public function getBrief_()
    {
        return fbt(Product::$tableCode, $this->product_id, 'brief', $this->name);
    }

    public function getThumb_()
    {
        return ImageHelper::getFullUrl($this->getProduct()->one()->thumb);
    }

    public function getCurrency_()
    {
        return MallHelper::getCurrentCurrencySymbol();
    }

    public function getPrice_()
    {
        return MallHelper::getNumberByCurrency($this->getProduct()->one()->price, 2, false);
    }
}
