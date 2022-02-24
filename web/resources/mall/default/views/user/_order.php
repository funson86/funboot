<?php
use common\models\mall\OrderProduct as ActiveModel;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\mall\Order;

/* @var $this yii\web\View */
/* @var  Order $model */
$order = $model;
$models = $order->orderProducts;
?>

<?php foreach ($models as $model) { ?>
<div class="info-box position-relative shadow-sm">
    <div class="info-box-content">
        <p class="info-box-text m-0"><?= $model->name ?></p>
        <p class="info-box-text small m-0">
            <?= \common\helpers\Html::color($model->order->status, Order::getStatusLabels($model->order->status), [Order::PAYMENT_STATUS_PAID, Order::PAYMENT_STATUS_COD, Order::SHIPMENT_STATUS_SHIPPING, Order::SHIPMENT_STATUS_RECEIVED], [Order::PAYMENT_STATUS_UNPAID]) ?>
            <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
            <i class="pull-right"><?= $this->context->getNumberByCurrency($model->price) ?></i>
        </p>
        <span class="info-box-text py-3 text-right">
            <!--<?= $model->order->payment_status != Order::PAYMENT_STATUS_UNPAID ? Html::a(Yii::t('app', 'Comment'), ['/mall/order/review', 'id' => $model->id], ['class' => 'btn btn-sm btn-info'], false) : '' ?>-->
            <?= $model->order->status != Order::SHIPMENT_STATUS_RECEIVED ? Html::a(Yii::t('app', 'Received'), ['/mall/order/review', 'id' => $model->order_id], ['class' => 'btn btn-sm btn-theme ml-3'], false) : '' ?>
        </span>
    </div>
</div>
<?php } ?>
