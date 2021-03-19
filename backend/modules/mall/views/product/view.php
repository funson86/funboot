<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\mall\Product as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card product-view">
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
                'category_id',
                'name',
                'sku',
                'stock_code',
                'stock',
                'stock_warning',
                'weight',
                'volume',
                'price',
                'market_price',
                'cost_price',
                'wholesale_price',
                'thumb',
                'images:json',
                'brief:ntext',
                'content:ntext',
                'seo_title',
                'seo_keywords',
                'seo_description:ntext',
                'brand_id',
                'vendor_id',
                'attribute_set_id',
                'star',
                'sales',
                'click',
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
