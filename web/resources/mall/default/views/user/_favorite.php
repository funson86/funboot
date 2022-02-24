<?php
use common\models\mall\Favorite as ActiveModel;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  ActiveModel $model */

$product = Yii::$app->cacheSystemMall->getProductById($model->product_id);
?>

<?php if ($product) { ?>
<div class="info-box position-relative shadow-sm">
    <div class="info-box-content">
        <p class="info-box-text m-0"><?= $product->name ?></p>
        <p class="info-box-text small m-0">
            Valid Before <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
        </p>
    </div>
</div>
<?php } ?>

