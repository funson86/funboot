<?php

namespace frontend\modules\mall\controllers;

use common\models\BaseModel;
use common\models\mall\Address;
use common\models\mall\Cart;
use common\models\mall\CouponType;
use common\models\mall\Order;
use common\models\mall\OrderLog;
use common\models\mall\OrderProduct;
use common\models\mall\PointLog;
use common\models\mall\Product;
use common\models\mall\ProductSku;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class CartController
 * @package frontend\modules\mall\controllers
 * @author funson86 <funson86@gmail.com>
 */
class CartController extends BaseController
{
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
        $productAmount = $discount = $total = 0;
        $models = Cart::find()
            ->where(['store_id' => $this->getStoreId()])
            ->andWhere(['or', ['session_id' => Yii::$app->session->id], ['user_id' => (Yii::$app->user->isGuest ? 0 : Yii::$app->user->id)]])
            ->all();
        foreach ($models as $model) {
            $productAmount += $model->price * $model->number;
        }

        $total = $productAmount;
        $coupon = Yii::$app->request->get('coupon');
        if ($coupon) {
            $discount = $this->getDiscount($productAmount, $coupon);
            $total += $discount;
            if ($discount === 0) {
                $this->flashWarning(Yii::t('app', 'Invalid Coupon Code: ') . $coupon);
                return $this->redirect(['/mall/cart/index']);
            }
        }

        return $this->render($this->action->id, [
            'models' => $models,
            'productAmount' => $productAmount,
            'discount' => $discount,
            'total' => $total,
        ]);
    }

    public function actionEditAjax()
    {
        $productId = Yii::$app->request->post('product_id');
        $number = intval(Yii::$app->request->post('number'));
        $productAttributeValue = Yii::$app->request->post('product_attribute_value');

        if ($number <= 0) {
            return $this->error(-1, Yii::t('mall', 'Number Error'));
        }

        $product = Product::findOne(['id' => $productId, 'store_id' => $this->getStoreId()]);
        if (!$product) {
            return $this->error(-2, Yii::t('mall', 'No Product Exist'));
        }
        $productSku = ProductSku::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $productId, 'attribute_value' => $productAttributeValue])->one();
        $productStock = $productSku ? $productSku->stock : $product->stock;
        if ($number > $productStock) {
            return $this->error(-2, Yii::t('mall', 'Stock is less than required'));
        }

        $model = Cart::find()
            ->where(['store_id' => $this->getStoreId(), 'product_id' => $productId, 'product_attribute_value' => $productAttributeValue])
            ->andWhere(['or', ['session_id' => Yii::$app->session->id], ['user_id' => (Yii::$app->user->isGuest ? 0 : Yii::$app->user->id)]])
            ->one();
        if (!$model) {
            $model = new Cart();
            $model->session_id = Yii::$app->session->id;
            $model->user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->id;
            $model->product_id = $productId;
            $model->product_attribute_value = $productAttributeValue;
            $model->number = $number;
            $model->name = $product->name;
            $model->sku = $productSku->sku ?? $product->sku;
            $model->market_price = $productSku->market_price ?? $product->market_price;
            $model->price = $productSku->price ?? $product->price;
            $model->thumb = $productSku->thumb ?? $product->thumb;
            $model->type = $product->type;

            if (!$model->save()) {
                Yii::$app->logSystem->db($model->errors);
                return $this->error();
            }
        } else {
            if (($model->number + $number) > $productStock) {
                return $this->error(-2, Yii::t('mall', 'Stock is less than required'));
            }

            $model->number += $number;
            if (!$model->save()) {
                Yii::$app->logSystem->db($model->errors);
                return $this->error();
            }
        }

        return $this->success();
    }

    public function actionUpdateAjax()
    {
        $type = Yii::$app->request->post('type');
        $id = Yii::$app->request->post('id');
        $number = intval(Yii::$app->request->post('number'));

        if (!$type || !$id) {
            return $this->error(-1, Yii::t('app', 'Invalid Param'));
        }

        $model = Cart::find()->where(['store_id' => $this->getStoreId(), 'id' => $id])->one();
        if (!$model) {
            return $this->error(-1, Yii::t('app', 'Invalid Param'));
        }

        // 计算库存
        $product = Yii::$app->cacheSystemMall->getProductById($model->product_id);
        $productSku = Yii::$app->cacheSystemMall->getProductSkuByProductId($model->product_id, $model->product_attribute_value);
        $productStock = $productSku->stock ?? $product->stock;

        if ($type == 'dec') {
            if ($model->number <= 1) {
                $model->delete();
            } else {
                $model->number -= 1;
                $model->save();
            }
        } elseif ($type == 'inc') {
            if ($model->number + 1 > $productStock) {
                return $this->error(-1, Yii::t('app', 'Stock less'));
            }
            $model->number += 1;
            $model->save();
        } elseif ($type == 'del') {
            $model->delete();
        } elseif ($type == 'mod') {
            if ($number <= 0) {
                return $this->error(-1, Yii::t('app', 'Invalid Param'));
            }
            if ($number > $productStock) {
                return $this->error(-1, Yii::t('app', 'Stock less'));
            }

            $model->number = $number;
            $model->save();
        }

        return $this->success();
    }

    public function actionCheckout()
    {
        /** @var Cart[] $carts */
        $carts = Cart::find()
            ->where(['store_id' => $this->getStoreId()])
            ->andWhere(['or', ['session_id' => Yii::$app->session->id], ['user_id' => (Yii::$app->user->isGuest ? 0 : Yii::$app->user->id)]])
            ->all();
        if (!count($carts)) {
            return $this->goBack();
        }

        // 判断库存是否充足
        $number = 0;
        $productAmount = $discount = $total = 0;
        foreach ($carts as $cart) {
            if (strlen($cart->product_attribute_value) > 0) {
                $productSku = ProductSku::findOne(['product_id' => $cart->product_id, 'attribute_value' => $cart->product_attribute_value]);
                if (!$productSku) {
                    return $this->redirectError(Yii::t('app', 'Input Param Error'));
                }
                if ($cart->number > $productSku->stock) {
                    $cart->number = $productSku->stock;
                    if (!$cart->save()) {
                        Yii::$app->logSystem->db($cart->errors);
                    }
                    return $this->redirectError(Yii::t('mall', 'Some product stock less than cart, update number to the stock'));
                }
                ProductSku::updateAllCounters(['stock' => -$cart->number], ['product_id' => $cart->product_id, 'attribute_value' => $cart->product_attribute_value]);
            } else {
                $product = Product::findOne(['id' => $cart->product_id]);
                if (!$product) {
                    return $this->redirectError(Yii::t('app', 'Input Param Error'));
                }
                if ($cart->number > $product->stock) {
                    $cart->number = $product->stock;
                    if (!$cart->save()) {
                        Yii::$app->logSystem->db($cart->errors);
                    }
                    return $this->redirectError(Yii::t('mall', 'Some product stock less than cart, update number to the stock'));
                }
            }

            $number += $cart->number;
            $productAmount += $cart->number * $cart->price;
        }

        // 计算总金额
        $total = $productAmount;
        $coupon = Yii::$app->request->get('coupon');
        if ($coupon) {
            $discount = $this->getDiscount($productAmount, $coupon);
            $total += $discount;
            if ($discount === 0) {
                $this->flashWarning(Yii::t('app', 'Invalid Coupon Code: ') . $coupon);
                return $this->redirect(['/mall/cart/index']);
            }
        }

        $model = new Order();
        if (Yii::$app->request->isPost) {
            $arrAddress = Yii::$app->request->post()['Address'];
            $address = Address::find()->where([
                'store_id' => $this->getStoreId(),
                'user_id' => Yii::$app->user->id,
                'first_name' => $arrAddress['first_name'],
                'last_name' => $arrAddress['last_name'],
                'address' => $arrAddress['address'],
                'district' => $arrAddress['district'],
                'mobile' => $arrAddress['mobile'],
                'country' => $arrAddress['country'],
                'postcode' => $arrAddress['postcode'],
            ])->orderBy(['is_default' => SORT_DESC, 'id' => SORT_DESC])->one();
            if (!$address) {
                $address = new Address();
            }
            $address->load(Yii::$app->request->post());
            $address->user_id = Yii::$app->user->id;
            if (!$address->save()) {
                Yii::$app->logSystem->db($address->errors);
                return $this->goBack();
            }

            $transaction = Yii::$app->db->beginTransaction();

            try {
                // refresh
                $address = Address::findOne($address->id);

                $model->load(Yii::$app->request->post());
                $model->user_id = Yii::$app->user->id;
                $model->sn = date('YmdHis') . rand(1000, 9999);
                $model->address_id = $address->id;
                $model->first_name = $address->first_name;
                $model->last_name = $address->last_name;
                $model->country = $address->country;
                $model->province = $address->province;
                $model->city = $address->city;
                $model->district = $address->district;
                $model->address = $address->address;
                $model->address2 = $address->address2;
                $model->postcode = $address->postcode;
                $model->mobile = $address->mobile;
                $model->email = $address->email;

                $model->product_amount = $productAmount;

                // 计算折扣
                $model->discount = $discount;
                $model->amount = $model->product_amount + $model->discount;

                if ($model->payment_method == Order::PAYMENT_METHOD_COD) {
                    $model->payment_status = Order::PAYMENT_STATUS_COD;
                } else {
                    $model->payment_status = Order::PAYMENT_STATUS_UNPAID;
                }
                $model->status = $model->payment_status;

                if (!$model->save()) {
                    Yii::$app->logSystem->db($model->errors);
                    throw new NotFoundHttpException($this->getError($model));
                }

                foreach ($carts as $cart) {
                    $orderProduct = new OrderProduct();
                    $orderProduct->store_id = $this->getStoreId();
                    $orderProduct->user_id = Yii::$app->user->id;
                    $orderProduct->order_id = $model->id;
                    $orderProduct->product_id = $cart->product_id;
                    $orderProduct->product_attribute_value = $cart->product_attribute_value;
                    $orderProduct->sku = $cart->sku;
                    $orderProduct->name = $cart->name;
                    $orderProduct->number = $cart->number;
                    $orderProduct->market_price = $cart->market_price;
                    $orderProduct->price = $cart->price;
                    $orderProduct->thumb = $cart->thumb;
                    $orderProduct->type = $cart->type;

                    if (!$orderProduct->save()) {
                        Yii::$app->logSystem->db($orderProduct->errors);
                        throw new NotFoundHttpException($this->getError($orderProduct));
                    }

                    // 减少商品的库存
                    if (strlen($cart->product_attribute_value) > 0) {
                        ProductSku::updateAllCounters(['stock' => -$cart->number], ['id' => $cart->product_id, 'attribute_value' => $cart->product_attribute_value]);
                    } else {
                        Product::updateAllCounters(['stock' => -$cart->number], ['id' => $cart->product_id]);
                    }
                }

                // 生成订单后，清空购物车，设置优惠码，更新积分和积分记录
                Cart::deleteAll(['user_id' => Yii::$app->user->id]);

                // 订单记录
                OrderLog::create($model->id, $model->status);

                // 积分 && 积分记录
                $original = Yii::$app->user->identity->point;
                $point = intval($model->amount);
                User::updateAllCounters(['point' => $point], ['id' => Yii::$app->user->id]);
                PointLog::create($point, $original, $original + $point, $model->id, PointLog::TYPE_BOUGHT);

                $transaction->commit();
                return $this->redirect(['/mall/payment/index', 'id' => $model->id]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->redirectError($e->getMessage());
            }
        }

        $address = Address::find()->where(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id])->orderBy(['is_default' => SORT_DESC, 'id' => SORT_DESC])->one();
        if (!$address) {
            $address = new Address();
            $address->setScenario('withoutRegion');
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'carts' => $carts,
            'productAmount' => $productAmount,
            'discount' => $discount,
            'total' => $total,
            'address' => $address,
        ]);
    }

    protected function getDiscount($productAmount, $sn)
    {
        if ($productAmount <= 0) {
            return 0;
        }

        $model = CouponType::findOne(['store_id' => $this->getStoreId(), 'sn' => $sn, 'status' => BaseModel::STATUS_ACTIVE]);
        if (!$model) {
            return 0;
        }

        return CouponType::getDiscountByCoupon($productAmount, $model);
    }
}
