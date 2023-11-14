<?php

namespace api\modules\v21\models;

use common\helpers\ImageHelper;
use common\helpers\MallHelper;
use common\models\Store;
use common\services\mall\BaseService;

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
            'id', 'store_id', 'name', 'sku', 'price', 'thumb', 'images', 'brief', 'content',
            'name_', 'brief_', 'content_', 'thumb_', 'price_', 'images_', 'currency_',
        ];
    }

    public function getName_()
    {
        return fbt(Product::$tableCode, $this->id, 'name', $this->name);
    }

    public function getBrief_()
    {
        return fbt(Product::$tableCode, $this->id, 'brief', $this->brief);
    }

    public function getContent_()
    {
        return fbt(Product::$tableCode, $this->id, 'content', $this->content);
    }

    public function getThumb_()
    {
        return ImageHelper::getFullUrl($this->thumb);
    }

    public function getCurrency_()
    {
        return MallHelper::getCurrentCurrencySymbol();
    }

    public function getPrice_()
    {
        return MallHelper::getNumberByCurrency($this->price, 2, false);
    }

    public function getImages_()
    {
        if (empty($this->images)) {
            return [];
        }

        $list = [];
        foreach ($this->images as $item) {
            $list[] = ImageHelper::getFullUrl($item);
        }

        return $list;
    }
}
