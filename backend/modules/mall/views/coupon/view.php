<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\mall\Coupon as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Coupon */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Coupons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card coupon-view">
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
                ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name ?? '-'; }, ],
                ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username ?? '-'; }, ],
                'coupon_type_id',
                'name',
                'money',
                'min_amount',
                'started_at:datetime',
                'ended_at:datetime',
                'min_product_amount',
                'sn',
                'order_id',
                'used_at:datetime',
                ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, ],
                'sort',
                ['attribute' => 'status', 'value' => function ($model) { return ActiveModel::getStatusLabels($model->status, true); }, ],
                'created_at:datetime',
                'updated_at:datetime',
                ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],
            ],
        ]) ?>

    </div>
</div>
