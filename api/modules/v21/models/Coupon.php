<?php

namespace api\modules\v21\models;

use common\models\Store;
use common\services\mall\BaseService;

/**
 * Class Coupon
 * @package api\modules\v21\models
 * @author funson86 <funson86@gmail.com>
 */
class Coupon extends \common\models\mall\Coupon
{
    public function fields()
    {
        return [
            'id', 'store_id', 'coupon_type_id', 'name', 'money', 'min_amount', 'started_at', 'ended_at',
            'min_product_amount', 'sn', 'coupon_type_id', 'used_at', 'type', 'status', 'created_at',
            'status_', 'money_', 'minAmount_',
        ];
    }

    public function getMoney_()
    {
        return Store::getCurrencyShortName(BaseService::getCurrentCurrency(), true, true) . number_format($this->money, 2);
    }

    public function getMinAmount_()
    {
        return Store::getCurrencyShortName(BaseService::getCurrentCurrency(), true, true) . number_format($this->min_amount, 2);
    }

}
