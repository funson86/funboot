<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\mall\Order as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body order-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
        'attributes' => [
            'id',
            'store_id',
            'user_id',
            'name',
            'sn',
            'consignee',
            'country_id',
            'province_id',
            'city_id',
            'district_id',
            'state',
            'address',
            'address1',
            'address2',
            'zipcode',
            'mobile',
            'email:email',
            'distance',
            'remark',
            'payment_method',
            'payment_fee',
            'payment_status',
            'paid_at:datetime',
            'shipment_id',
            'shipment_name',
            'shipment_fee',
            'shipment_status',
            'shipped_at:datetime',
            'product_amount',
            'amount',
            'extra_fee',
            'discount',
            'tax',
            'invoice',
            'type',
            'sort',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
