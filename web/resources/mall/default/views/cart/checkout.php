<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\mall\Order;
use common\models\mall\Product;

/* @var $this yii\web\View */
/* @var $model \common\models\mall\Order */
/* @var $carts \common\models\mall\Cart[] */
/* @var $address \common\models\mall\Address */
/* @var $productAmount float */
/* @var $discount float */
/* @var $total float */
$this->title = Yii::t('app', 'Checkout');
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="page-section checkout">
    <div class="container">
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'checkout-form']); ?>
            <div class="row">
                <div class="col-lg-8">
                    <h5><?= Yii::t('mall', 'Billing detail') ?></h5>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout-form-input">
                                <?= $form->field($address, 'first_name', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(Yii::t('app', 'First Name') . '*')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout-form-input">
                                <?= $form->field($address, 'last_name', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(Yii::t('app', 'Last Name') . '*')->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout-form-input">
                                <?= $form->field($address, 'address', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(Yii::t('app', 'Address') . '*')->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                                <?= $form->field($address, 'district', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(Yii::t('mall', 'District(optional)'))->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout-form-input">
                                <?= $form->field($address, 'city', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(Yii::t('mall', 'City(Optional)'))->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout-form-input">
                                <?= $form->field($address, 'province', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(Yii::t('mall', 'State / Province') . '*')->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout-form-input">
                                <?= $form->field($address, 'country', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(Yii::t('app', 'Country') . '*')->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout-form-input">
                                <?= $form->field($address, 'mobile', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(Yii::t('app', 'Mobile') . '*')->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout-form-input">
                                <?= $form->field($address, 'postcode', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(Yii::t('app', 'Postcode') . '*')->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout-form-checkbox">
                                <?= $form->field($model, 'remark')->textarea(['rows' => 2]) ?>
                            </div>
                        </div>
                    </div>
                    <!--div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="discount-content">
                                <h6>Discount codes</h6>
                                <dd>
                                    <input type="text" id="coupon-code" placeholder="Enter coupon code">
                                    <button id="coupon-btn" class="site-btn">Apply</button>
                                </dd>
                            </div>
                        </div>
                    </div-->
                </div>
                <div class="col-lg-4">
                    <div class="checkout-order">
                        <h5><?= Yii::t('mall', 'Your Order') ?></h5>
                        <div class="checkout-order-product">
                            <ul>
                                <li>
                                    <span class="top-text"><?= Yii::t('app', 'Product') ?></span>
                                    <span class="top-text-right"><?= Yii::t('app', 'Subtotal') ?></span>
                                </li>
                                <?php foreach ($carts as $cart) { ?>
                                <li><?= $cart->number ?> x <?= fbt(Product::getTableCode(), $cart->product_id, 'name', $cart->name) ?><span><?= $this->context->getNumberByCurrency($cart->price) ?></span></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="checkout-order-total">
                            <ul>
                                <li><?= Yii::t('app', 'Subtotal') ?> <span><?= $this->context->getNumberByCurrency($productAmount) ?></span></li>
                                <?php if ($discount <> 0) { ?><li><?= Yii::t('app', 'Discount') ?> <span><?= $this->context->getNumberByCurrency($discount) ?></span></li><?php } ?>
                                <li><?= Yii::t('app', 'Total') ?> <span><?= $this->context->getNumberByCurrency($total) ?></span></li>
                            </ul>
                        </div>
                        <div class="checkout-order-widget">
                            <label>
                                <input type="radio" name="Order[payment_method]" value="<?= Order::PAYMENT_METHOD_PAY ?>" checked>
                                <?= Yii::t('mall', 'Online Pay') ?>
                                <span class="checkmark"></span>
                            </label>
                            <label>
                                <input type="radio" name="Order[payment_method]" value="<?= Order::PAYMENT_METHOD_COD ?>">
                                <?= Yii::t('mall', 'Cash on Delivery') ?>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <button type="submit" class="site-btn"><?= Yii::t('mall', 'Place Order') ?></button>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>

