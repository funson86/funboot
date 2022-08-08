<?php
use common\models\mall\Favorite as ActiveModel;
use yii\helpers\Html;
use common\models\mall\Product;

/* @var $this yii\web\View */
/* @var  ActiveModel $model */

$product = Yii::$app->cacheSystemMall->getProductById($model->product_id);
?>

<?php if ($product) { ?>
<div class="product-item">
    <div class="product-item-pic set-bg" data-setbg="<?= $this->context->getImage($product->thumb) ?>">
        <div class="label type-<?= $product->getTypeOne() ?>"><?= Yii::t('mall', $product->getTypeOne(true)) ?></div>
        <ul class="product-hover">
            <li><a href="<?= $this->context->getImage($product->image) ?>" data-fancybox="gallery"><i class="fa fa-expand"></i></a></li>
            <li><a href="<?= $this->context->getSeoUrl($product) ?>"><i class="fa fa-shopping-bag"></i></a></li>
        </ul>
    </div>
    <div class="product-item-text">
        <h6><?= Html::a(fbt(Product::getTableCode(), $product->id, 'name', $product->name), $this->context->getSeoUrl($product)) ?></h6>
        <div class="rating">
            <?= \common\helpers\UiHelper::renderStar($product->star) ?>
        </div>
        <div class="product-price"><?= $this->context->getNumberByCurrency($product->price) ?></div>
    </div>
</div>
<?php } ?>

