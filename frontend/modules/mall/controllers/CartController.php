<?php

namespace frontend\modules\mall\controllers;

use common\models\mall\Address;
use common\models\mall\Cart;
use common\models\mall\Order;
use common\models\mall\Product;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class CartController
 * @package frontend\modules\mall\controllers
 * @author funson86 <funson86@gmail.com>
 */
class CartController extends BaseController
{
    public $layout = 'cart';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['checkout', 'address', 'pay', 'cod', 'json-coupon'],
                'rules' => [
                    [
                        'actions' => ['checkout', 'address', 'pay', 'cod', 'json-coupon'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->request->get('type') && Yii::$app->request->get('product_id')) {
            $type = Yii::$app->request->get('type');
            $productId = Yii::$app->request->get('product_id');
            $product = Product::findOne($productId);
            $cartProduct = Cart::find()->where(['session_id' => Yii::$app->session->id, 'product_id' => $productId])->one();

            if ($type == 'minus' && $cartProduct->number > 1) { //减少一个
                Cart::updateAllCounters(['number' => -1], ['session_id' => Yii::$app->session->id, 'product_id' => $productId]);
            } elseif ($type == 'add' && $cartProduct->number < $product->stock) { //增加一个
                Cart::updateAllCounters(['number' => 1], ['session_id' => Yii::$app->session->id, 'product_id' => $productId]);
            } elseif ($type == 'change' && Yii::$app->request->get('value')) { //修改为指定的数量
                $productId = Yii::$app->request->get('change');
                $value = Yii::$app->request->get('value');
                Cart::updateAll(['number' => $value], ['session_id' => Yii::$app->session->id, 'product_id' => $productId]);
            }
            Cart::deleteAll('number <= 0');
            return $this->success();
        }

        $products = Cart::find()->where(['or', 'session_id = "' . Yii::$app->session->id . '"', 'user_id = ' . (Yii::$app->user->id ? Yii::$app->user->id : -1)])->all();
        if (count($products)) {
            // 如果购物车的数量大于商品的库存，则设置为最大的库存
            return $this->render('index', [
                'products' => $products,
            ]);
        } else {
            return $this->render('cart-no-product', [
                'products' => $products,
            ]);
        }
    }

    public function actionCheckout()
    {
        $userId = Yii::$app->user->id;
        $addresses = Address::find()->where(['user_id' => $userId])->all();

        $model = new Order();

        if ($model->load(Yii::$app->request->post())) {
            if (!Yii::$app->request->post('address_id')) {
                return $this->goBack();
            }

            // 使用优惠券
            $feeCouponUser = $feeCouponCode = $feePoint = 0.00;
            $couponId = Yii::$app->request->post('coupon');
            if ($couponId && Yii::$app->request->post('checkbox-coupon')) {
                $couponUser = Coupon::findOne($couponId);
                if (!$couponUser || $couponUser->used_at > 0 || $couponUser->ended_at < time() || $couponUser->user_id != Yii::$app->user->id) {
                    return $this->goBack();
                }
                $feeCouponUser = $couponUser->money;
            }

            // 使用优惠码
            $sn = Yii::$app->request->post('sn');
            if ($sn) {
                $couponCode = Coupon::find()->where(['sn' => $sn])->one();
                if (!$couponCode || $couponCode->used_at > 0 || $couponCode->ended_at < time()) {
                    return $this->goBack();
                }
                $feeCouponCode = $couponCode->money;
            }

            // 使用积分
            $point = Yii::$app->request->post('point');
            if ($point && Yii::$app->request->post('checkbox-point')) {
                if ($point > Yii::$app->user->identity->point) {
                    return $this->goBack();
                }
                $feePoint = intval($point) / 100;
            }

            $address = Address::find()->where(['id' => Yii::$app->request->post('address_id'), 'user_id' => $userId])->one();
            $model->user_id = $userId;
            $model->sn = date('YmdHis') . rand(1000, 9999);
            $model->consignee = $address->consignee;
            $model->country = $address->country;
            $model->province = $address->province;
            $model->city = $address->city;
            $model->district = $address->district;
            $model->address = $address->address;
            $model->zipcode = $address->zipcode;
            $model->phone = $address->phone;
            $model->mobile = $address->mobile;
            $model->email = $address->email ? $address->email : Yii::$app->user->identity->email;
            if ($model->payment_method == Order::PAYMENT_METHOD_COD) {
                $model->payment_status = Order::PAYMENT_STATUS_COD;
            } else {
                $model->payment_status = Order::PAYMENT_STATUS_UNPAID;
            }
            $model->status = $model->payment_status;

            $products = Cart::find()->where(['session_id' => Yii::$app->session->id])->all();
            if (count($products)) {
                foreach($products as $product) {
                    $model->amount += $product->number * $product->price;
                }
            } else {
                $this->redirect('/mall/cart');
            }
            // 判断是否免邮
            if ($model->amount < Yii::$app->params['freeShipmentAmount']) {
                $model->shipment_fee = Yii::$app->params['defaultShipmentFee'];
            }
            $model->amount += floatval($model->shipment_fee) - $feeCouponUser - $feeCouponCode - $feePoint;

            if ($model->save()) {
                // insert order_product and clear cart
                foreach ($products as $product) {
                    $orderProduct = new OrderProduct();
                    $orderProduct->order_id = $model->id;
                    $orderProduct->product_id = $product->product_id;
                    $orderProduct->sku = $product->sku;
                    $orderProduct->name = $product->name;
                    $orderProduct->number = $product->number;
                    $orderProduct->market_price = $product->market_price;
                    $orderProduct->price = $product->price;
                    $orderProduct->thumb = $product->thumb;
                    $orderProduct->type = $product->type;

                    $orderProduct->save();

                    // 减少商品的库存
                    Product::updateAllCounters(['stock' => - $product->number], ['id' => $product->product_id]);
                }

                // 生成订单后，清空购物车，设置优惠码，更新积分和积分记录
                Cart::deleteAll(['session_id' => Yii::$app->session->id]);
                if (isset($couponUser) && Yii::$app->request->post('checkbox-coupon')) {
                    $couponUser->used_at = time();
                    $couponUser->order_id = $model->id;
                    $couponUser->save();
                }
                if (isset($couponCode) && Yii::$app->request->post('checkbox-coupon')) {
                    $couponCode->user_id = Yii::$app->user->id;
                    $couponCode->used_at = time();
                    $couponCode->order_id = $model->id;
                    $couponCode->save();
                }
                if (isset($point) && Yii::$app->request->post('checkbox-point')) {
                    $balance = Yii::$app->user->identity->point - $point;
                    User::updateAllCounters(['point' => - $point], ['id' => Yii::$app->user->id]);
                    $pointLog = new PointLog([
                        'user_id' => Yii::$app->user->id,
                        'type' => PointLog::POINT_TYPE_BUYING,
                        'point' => - $point,
                        'balance' => $balance,
                    ]);
                    $pointLog->save();
                }

                // 记录订单日志
                $orderLog = new OrderLog([
                    'order_id' => $model->id,
                    'status' => $model->status,
                ]);
                $orderLog->save();

                // 不同的付款方式到不同的页面
                if ($model->payment_method == Order::PAYMENT_METHOD_COD) {
                    return $this->redirect(['cart/cod',
                        'id' => $model->id,
                    ]);
                } else {
                    return $this->redirect(['cart/pay',
                        'sn' => $model->sn,
                    ]);

                }
            }

        }

        $products = Cart::find()->where(['session_id' => Yii::$app->session->id])->all();
        if (!count($products)) {
            return $this->redirect('/mall/cart');
        } if (count($addresses)) {
        return $this->render('checkout', [
            'model' => $model,
            'addresses' => $addresses,
            'products' => $products,
        ]);
    } else {
        return $this->redirect(['/mall/cart/address']);
    }

    }

    public function actionAddress($id = null)
    {
        if ($id) {
            $model = Address::findOne($id);
            if ($model === null)
                throw new NotFoundHttpException('model does not exist.');
        } else {
            $model = new Address();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if ($model->save())
                return $this->redirect(['/mall/cart/checkout']);
        }

        return $this->render('address', [
            'model' => $model,
        ]);
    }

    public function actionPay($sn)
    {
        $model = Order::find()->where(['sn' => $sn])->one();
        if ($model === null)
            throw new NotFoundHttpException('model does not exist.');

        return $this->render('pay', [
            'model' => $model,
        ]);
    }

    public function actionCod($id)
    {
        $model = Order::find()->where(['id' => $id])->one();
        if ($model === null)
            throw new NotFoundHttpException('model does not exist.');

        return $this->render('cod', [
            'model' => $model,
        ]);
    }

    public function actionAddToCart($id)
    {
        if (!$id)
            $this->redirect(['/cart']);

        return $this->render('add-to-cart', [
            'id' => $id,
        ]);
    }

    public function actionDelete($id)
    {
        Cart::deleteAll(['and', ['or', 'session_id = "' . Yii::$app->session->id . '"', 'user_id = ' . (Yii::$app->user->id ? Yii::$app->user->id : -1)], 'product_id = ' . $id]);
        $this->redirect(['/cart']);
    }

    public function actionDestroy()
    {
        Cart::deleteAll(['session_id' => Yii::$app->session->id]);
        $this->goHome();
    }

    public function actionJsonList()
    {
        $totalNumber = 0;
        $totalPrice = 0;
        $products = Cart::find()->where(['or', 'session_id = "' . Yii::$app->session->id . '"', 'user_id = ' . (Yii::$app->user->id ? Yii::$app->user->id : -1)])->asArray()->all();
        foreach ($products as $product) {
            $totalNumber += $product['number'];
            $totalPrice += $product['number'] * $product['price'];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => 1,
            'totalNumber' => $totalNumber,
            'totalPrice' => $totalPrice,
            'data' => $products,
        ];
    }

    public function actionJsonCoupon()
    {
        $products = Cart::find()->where(['user_id' => Yii::$app->user->id])->all();
        $totalProduct = $totalPrice = 0;
        foreach($products as $product) {
            $totalProduct += $product->number;
            $totalPrice += $product->number * $product->price;
        }

        $coupons = Coupon::find()->where(['and', 'user_id = ' . Yii::$app->user->id, 'min_amount < ' . $totalPrice, 'used_at = 0'])->asArray()->all();
        foreach ($coupons as $k => $item) {
            $coupons[$k]['ended_time'] = date('Y-m-d', $item['ended_at']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => 1,
            'count' => count($coupons),
            'data' => $coupons,
        ];
    }

    public function actionAjaxCouponCode($sn)
    {
        $sn = trim($sn);
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$sn) {
            return ['status' => -1];
        }

        $coupon = Coupon::find()->where(['sn' => $sn])->one();
        if (!$coupon) {
            return ['status' => -1];
        }

        if ($coupon->used_at > 0) {
            return ['status' => -2];
        } elseif ($coupon->ended_at < time()) {
            return ['status' => -3];
        }

        return [
            'status' => 1,
            'sn' => $coupon->sn,
            'money' => $coupon->money,
        ];
    }

    public function actionAjaxAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $productId = Yii::$app->request->post('productId');
        $number = Yii::$app->request->post('number');
        if ($productId && $number) {
            // 如果购物车已有，则更新，否则在购物车中增加
            if ($cart = Cart::find()->where(['and', 'product_id = ' . $productId, ['or', 'session_id="' . Yii::$app->session->id . '"', 'user_id=' . (Yii::$app->user->isGuest ? 0 : Yii::$app->user->id)]])->one()) {
                $product = Product::findOne($productId);
                if ($cart->number + $number <= $product->stock) {
                    if (!Yii::$app->user->isGuest) { //如果已登录，将session id更新为当前session
                        $cart->updateAll(['session_id' => Yii::$app->session->id], ['user_id' => Yii::$app->user->id]);
                    }
                    $cart->updateAllCounters(['number' => $number], ['and', 'product_id=' . $productId, ['or', 'session_id="' . Yii::$app->session->id . '"', 'user_id=' . (Yii::$app->user->isGuest ? 0 : Yii::$app->user->id)]]);
                    return [
                        'status' => 1,
                        'productId' => $productId,
                        'number' => $number,
                    ];
                } else {
                    return [
                        'status' => -2,
                        'productId' => $productId,
                        'number' => $number,
                    ];
                }
            } elseif ($model = Product::findOne($productId)) {
                if ($model->stock >= $number) {
                    $cart = new Cart();
                    $cart->session_id = Yii::$app->session->id;
                    $cart->user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->id;
                    $cart->product_id = $productId;
                    $cart->number = $number;
                    $cart->sku = $model->sku;
                    $cart->name = $model->name;
                    $cart->market_price = $model->market_price;
                    $cart->price = $model->price;
                    $cart->thumb = $model->thumb;
                    $cart->type = $model->type;

                    if ($cart->save()) {
                        return [
                            'status' => 1,
                            'productId' => $productId,
                            'number' => $number,
                        ];
                    } else {
                        return [
                            'status' => -5,
                            'productId' => $productId,
                            'number' => $number,
                        ];
                    }
                } else {
                    return [
                        'status' => -2,
                        'productId' => $productId,
                        'number' => $number,
                    ];
                }
            }
        }

        return [
            'status' => -1,
            'productId' => $productId,
            'number' => $number,
        ];

    }

}