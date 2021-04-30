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
<div class="card order-view">
    <div class="card-header">
        <?= Html::a(Yii::t('app', 'Update'), ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="card-body">

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-hover box'],
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
</div>
