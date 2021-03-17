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

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body product-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
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
            'tags:json',
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
