<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\mall\Product as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language]['Products'] ?? null) ?></h2>
                <div class="card-tools">
                    <?= Html::create() ?>
                    <?= Html::export() ?>
                    <?= Html::import() ?>
                </div>
            </div>
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => false,
                        ],

                        'id',
                        ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', ArrayHelper::map($this->context->getStores(), 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'category_id',
                        ['attribute' => 'category_id', 'format' => 'raw', 'value' => function ($model) { return $model->category->name; }, 'filter' => Html::activeDropDownList($searchModel, 'category_id', \common\models\mall\Category::getTreeIdLabel(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'name',
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        'sku',
                        // 'stock_code',
                        'stock',
                        // 'stock_warning',
                        // 'weight',
                        // 'volume',
                        'price',
                        'market_price',
                        // 'cost_price',
                        // 'wholesale_price',
                        'thumb',
                        // 'images:json',
                        // 'brief:ntext',
                        // 'content:ntext',
                        // 'seo_title',
                        // 'seo_keywords',
                        // 'seo_description:ntext',
                        // 'brand_id',
                        // 'vendor_id',
                        // 'attribute_set_id',
                        ['attribute' => 'attribute_set_id', 'format' => 'raw', 'value' => function ($model) { return $model->attributeSet->name; }, 'filter' => Html::activeDropDownList($searchModel, 'attribute_set_id', \common\models\mall\AttributeSet::getIdLabel(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'star',
                        // 'sales',
                        // 'click',
                        // 'type',
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return Html::status($model->status); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'created_at:datetime',
                        // 'updated_at:datetime',
                        // 'created_by',
                        // 'updated_by',

                        Html::actionsRedirect(),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
