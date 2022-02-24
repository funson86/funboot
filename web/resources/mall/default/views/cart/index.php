<?php
use yii\helpers\Url;
use common\models\mall\Product;
use common\models\mall\AttributeItem;

/* @var $this yii\web\View */
/* @var $models \common\models\mall\Cart[] */
/* @var $productAmount float */
/* @var $discount float */
/* @var $total float */

$this->title = Yii::t('mall', 'Shopping Cart');
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="page-section shop-cart">
    <div class="container">
        <?php if (count($models)) { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-cart-table">
                    <table>
                        <thead>
                        <tr>
                            <th><?= Yii::t('app', 'Product') ?></th>
                            <th><?= Yii::t('app', 'Price') ?></th>
                            <th><?= Yii::t('app', 'Quantity') ?></th>
                            <th><?= Yii::t('app', 'Total') ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($models as $model) { $product = Yii::$app->cacheSystemMall->getProductById($model->product_id); ?>
                        <tr data-id="<?= $model->id ?>">
                            <td class="cart-product-item">
                                <a href="<?= $this->context->getSeoUrl($product) ?>">
                                    <?= strlen($model->thumb) > 5 ? "<img src='{$model->thumb}'>" : '' ?>
                                    <div class="cart-product-item-title">
                                        <h6>
                                            <?= fbt(Product::getTableCode(), $product->id, 'name', $model->name) ?>
                                            <?php if (strlen($model->product_attribute_value) > 0) {
                                                $arr = [];
                                                $arrProductAttributeValue = explode(',', $model->product_attribute_value);
                                                foreach ($arrProductAttributeValue as $attributeItemId) {
                                                    $attributeItem = Yii::$app->cacheSystemMall->getAttributeItemById($attributeItemId);
                                                    if ($attributeItem) {
                                                        array_push($arr, fbt(AttributeItem::getTableCode(), $attributeItem->id, 'name', $attributeItem->name));
                                                    }
                                                }
                                                if (count($arr) > 0) {
                                                    echo '<span>[' . implode(', ', $arr) . ']</span>';
                                                }
                                            } ?>
                                        </h6>
                                        <div class="rating">
                                            <?= \common\helpers\UiHelper::renderStar($product->star) ?>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td class="cart-price"><?= $this->context->getNumberByCurrency($model->price) ?></td>
                            <td class="cart-quantity">
                                <div class="pro-qty" data-id="<?= $model->id ?>">
                                    <span class="dec qtybtn click-btn" data-type="dec">-</span>
                                    <input type="text" value="<?= $model->number ?>" class="number-btn" data-type="mod">
                                    <span class="inc qtybtn click-btn" data-type="inc">+</span>
                                </div>
                            </td>
                            <td class="cart-total"><?= $this->context->getNumberByCurrency($model->price * $model->number) ?></td>
                            <td class="cart-close click-btn" data-type="del"><span class="fa fa-close" data-id="<?= $model->id ?>"></span></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="cart-btn">
                    <a href="<?= Url::to(['/']) ?>"><?= Yii::t('mall', 'Go Shopping') ?></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="cart-btn update-btn">
                    <a href="<?= Url::to(['/mall/cart']) ?>"><span class="fa fa-refresh"></span> <?= Yii::t('app', 'Refresh') ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="discount-content">
                    <h6><?= Yii::t('mall', 'Discount code') ?></h6>
                    <dd>
                        <input type="text" id="coupon-code" placeholder="<?= Yii::t('mall', 'Enter your coupon code') ?>">
                        <button type="button" class="site-btn" id="coupon-apply"><?= Yii::t('app', 'Apply') ?></button>
                    </dd>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-2">
                <div class="cart-total-procced">
                    <h6><?= Yii::t('mall', 'Cart Total') ?></h6>
                    <ul>
                        <li><?= Yii::t('app', 'Subtotal') ?> <span><?= $this->context->getNumberByCurrency($productAmount) ?></span></li>
                        <?php if ($discount <> 0) { ?><li><li><?= Yii::t('app', 'Discount') ?> <span><?= $this->context->getNumberByCurrency($discount) ?></span></li><?php } ?>
                        <li><?= Yii::t('app', 'Total') ?> <span><?= $this->context->getNumberByCurrency($total) ?></span></li>
                    </ul>
                    <a href="<?= Yii::$app->request->get('coupon') ? Url::to(['/mall/cart/checkout', 'coupon' => Yii::$app->request->get('coupon')]) : Url::to(['/mall/cart/checkout']) ?>" class="primary-btn"><?= Yii::t('mall', 'Proceed to checkout') ?></a>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="py-5">
                    <h2><?= Yii::t('mall', 'Your cart is currently empty') ?></h2>
                    <p><?= Yii::t('mall', 'Please add some products to your shopping cart before proceeding to checkout.') ?></p>
                </div>
                <div class="pb-5">
                    <a href="<?= Url::to(['/']) ?>" class="site-btn"><?= Yii::t('mall', 'Shopping Now') ?></a>
                </div>
            </div>

        </div>
        <?php } ?>
    </div>
</section>

<script>
$('.click-btn').click(function () {
    let param = {
        id: $(this).parent().data('id'),
        type: $(this).data('type'),
        _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
    };
    $.post('<?= Url::to(['/mall/cart/update-ajax']) ?>', param, function(data) {
        if (data.code !== 200) {
            Swal.fire(data.msg);
        }
        window.location.reload();
    }, "json");
})
$('.number-btn').change(function () {
    let param = {
        id: $(this).parent().data('id'),
        type: $(this).data('type'),
        number: $(this).val(),
        _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
    };
    $.post('<?= Url::to(['/mall/cart/update-ajax']) ?>', param, function(data) {
        if (data.code !== 200) {
            Swal.fire(data.msg);
        }
        window.location.reload();
    }, "json");
})
$('#coupon-apply').click(function () {
    let coupon = $('#coupon-code').val();
    if (coupon.length > 0) {
        window.location.href = '<?= Url::to(['/mall/cart/index']) ?>?coupon=' + coupon;
    }
})
</script>
