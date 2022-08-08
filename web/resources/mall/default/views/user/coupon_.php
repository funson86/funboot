<?php
use common\models\mall\Coupon as ActiveModel;
use yii\helpers\Html;
use common\models\mall\Coupon;
use common\models\mall\CouponType;

/* @var $this yii\web\View */
/* @var  ActiveModel $model */
?>

<div class="info-box position-relative shadow-sm">
    <div class="info-box-content">
        <p class="info-box-text m-0"><?= $model->name ?> <span class="pull-right"><?= CouponType::getMoneyLabel($model->money, $model->type) ?></span></p>
        <p class="info-box-text small m-0">
            <?= \common\helpers\Html::color($model->status, Coupon::getStatusLabels($model->status), [Coupon::STATUS_ACTIVE], [Coupon::STATUS_USED, Coupon::STATUS_EXPIRED]) ?>
            Valid Before <?= Yii::$app->formatter->asDatetime($model->ended_at) ?>
        </p>
    </div>
</div>
