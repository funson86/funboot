<?php
use frontend\helpers\Url;
use yii\helpers\Html;
use common\models\mall\Order;

$this->title = ($model->payment_method == Order::PAYMENT_METHOD_COD ? Yii::t('mall', 'Order has been confirmed') : Yii::t('mall', 'Order has been paid successfully'));
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row page-section">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12 px-4">
        <div class="card message-send-view">
            <div class="card-header text-center">
                <?= Html::encode($this->title) ?>
            </div>

            <div class="card-body">
                <p class="attention-icon"><i class="fa fa-check text-success"></i></p>
                <div class="form-group text-center">
                    <p><?= Yii::t('mall', 'Thank you! We will dispatch order ') ?><?= $model->sn ?> <?= Yii::t('mall', ' as soon as possible') ?></p>
                </div>
                <div class="form-group text-center pt-3">
                    <?= Html::a(Yii::t('mall', 'Go home to order more'), ['/'], ['class' => 'btn btn-success control-full']) ?>
                </div>

            </div>
        </div>
    </div>
</div>
