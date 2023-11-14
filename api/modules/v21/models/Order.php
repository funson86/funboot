<?php

namespace api\modules\v21\models;

use common\helpers\ImageHelper;
use common\helpers\MallHelper;

/**
 * Class User
 * @package api\models\food
 * @author funson86 <funson86@gmail.com>
 */
class Order extends \common\models\mall\Order
{
    public function fields()
    {
        return [
            'id', 'user_id', 'sn', 'first_name', 'last_name', 'country', 'province', 'province', 'city',
            'district', 'address', 'address2', 'postcode', 'mobile', 'email', 'remark', 'payment_method', 'payment_status',
            'paid_at', 'shipment_id', 'shipment_name', 'shipment_fee', 'shipment_status', 'shipped_at',
            'product_amount', 'amount', 'number', 'extra_fee', 'discount', 'invoice', 'type', 'status', 'created_at',
            'paymentMethod_', 'paymentStatus_', 'shipmentId_', 'shipmentStatus_', 'status_', 'currency_', 'amount_',
            'orderProducts', 'thumbs_', 'count_'
        ];
    }

    /**
     * 指定extraFields中显示哪些字段
     * @return array|\yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return parent::getOrderProducts()->select(['id', 'parent_id', 'thumb', 'name', 'price', 'number', 'sku']);
    }

    public function getPaymentMethod_()
    {
        return self::getPaymentMethodLabels($this->payment_method);
    }

    public function getPaymentStatus_()
    {
        return self::getPaymentStatusLabels($this->payment_status);
    }

    public function getShipmentId_()
    {
        return (string)self::getShipmentIdLabels($this->shipment_id);
    }

    public function getShipmentStatus_()
    {
        return self::getStatusLabels($this->shipment_status);
    }

    public function getStatus_()
    {
        return self::getStatusLabels($this->status);
    }

    public function getAmount_()
    {
        return MallHelper::getNumberByCurrency($this->amount, 2, false);
    }

    public function getCurrency_()
    {
        return MallHelper::getCurrentCurrencySymbol();
    }

    public function getThumbs_()
    {
        $arr = [];
        $orderProducts = $this->getOrderProducts()->all();
        $i = 0;
        foreach ($orderProducts as $orderProduct) {
            if ($i >= 3) {
                break;
            }
            strlen($orderProduct->thumb) > 0 && array_push($arr, ImageHelper::getFullUrl($orderProduct->thumb));
            $i++;
        }
        return implode('|', $arr);
    }

    public function getCount_()
    {
        $count = 0;
        $orderProducts = $this->getOrderProducts()->all();
        foreach ($orderProducts as $orderProduct) {
            $count += $orderProduct->number;
        }
        return $count;
    }
}
