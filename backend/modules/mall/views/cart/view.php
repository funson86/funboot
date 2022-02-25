<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\mall\Cart as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Cart */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Carts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card cart-view">
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
                'parent_id',
                'user_id',
                'session_id',
                'product_id',
                'product_attribute_value',
                'name',
                'thumb',
                'sku',
                'number',
                'price',
                'market_price',
                'cost_price',
                'wholesale_price',
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
