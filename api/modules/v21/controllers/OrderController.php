<?php

namespace api\modules\v21\controllers;

use api\modules\v21\models\Address;
use api\modules\v21\models\Order;
use api\modules\v21\models\Product;
use common\helpers\IdHelper;
use common\helpers\ImageHelper;
use common\models\mall\OrderProduct;
use Yii;

/**
 * Class ProductController
 * @package api\modules\v21\controllers
 * @author funson86 <funson86@gmail.com>
 */
class OrderController extends \api\controllers\BaseController
{
    public $modelClass = Order::class;

    public $optionalAuth = [];

    protected function filterParams(&$params)
    {
        $params['user_id'] = Yii::$app->user->id;
    }

    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        if (!$post['address_id']) {
            return $this->error();
        }

        $orderProducts = $post['orderProducts'];
        if (!$orderProducts || count($orderProducts) <= 0) {
            return $this->error();
        }

        $address = Address::findOne(['user_id' => Yii::$app->user->id, 'id' => $post['address_id']]);
        if (!$address) {
            return $this->error();
        }

        $productAmount = 0;
        foreach ($orderProducts as $orderProduct) {
            $product = Product::findOne(['store_id' => $this->getStoreId(), 'id' => $orderProduct['product_id']]);
            if (!$product) {
                continue;
            }
            $productAmount += intval($orderProduct['number']) * floatval($product['price']);
        }
        if ($productAmount <= 0) {
            return $this->error();
        }

        $order = new Order;
        $order->store_id = Yii::$app->user->identity->store_id;
        $order->user_id = Yii::$app->user->id;
        $order->address_id = $post['address_id'];
        $order->product_amount = $productAmount;
        $order->sn = date('YmdHis') . rand(1000, 9999);
        $order->amount = $order->product_amount;
        $order->shipment_id = 1;
        $order->save();

        foreach ($orderProducts as $orderProduct) {
            $product = Product::findOne(['store_id' => $this->getStoreId(), 'id' => $orderProduct['product_id']]);
            if (!$product) {
                continue;
            }

            $child = new OrderProduct();
            $child->store_id = Yii::$app->user->identity->store_id;
            $child->user_id = Yii::$app->user->id;
            $child->order_id = $order->id;
            $child->thumb = ImageHelper::getFullUrl($product->thumb);
            $child->name = fbt(Product::getTableCode(), $product->id, 'name', $product->name);
            $child->sku = $product->sku;
            $child->price = $product->price;
            $child->product_id = $orderProduct['product_id'];
            $child->number = $orderProduct['number'];
            $child->save();
        }

        return $this->success($order);
    }
}
