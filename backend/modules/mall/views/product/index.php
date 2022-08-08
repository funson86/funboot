<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\mall\Product as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;
use common\helpers\ImageHelper;

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
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->module->id . '_' . $this->context->id] ?? null) ?></h2>
                <div class="card-tools">
                    <?= Html::filterModal() ?>
                    <?= Html::create() ?>
                    <?= Html::export() ?>
                    <?= Html::import() ?>
                </div>
            </div>
            <div class="card-body">
                <?//= $this->render('@backend/views/site/_select', ['model' => $searchModel, 'dataProvider' => $dataProvider]) ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'visible' => false,
                        ],

                        'id',
                        ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', $this->context->getStoresIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
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
                        ['attribute' => 'thumb', 'filter' => false, 'format' => 'raw', 'value' => function ($model) { return ImageHelper::fancyBox($model->thumb); },],
                        // 'image',
                        // 'images:json',
                        // 'brief:ntext',
                        // 'content:ntext',
                        'seo_url',
                        // 'seo_title',
                        // 'seo_keywords',
                        // 'seo_description:ntext',
                        // 'brand_id',
                        // 'vendor_id',
                        // 'attribute_set_id',
                        ['attribute' => 'attribute_set_id', 'format' => 'raw', 'value' => function ($model) { return $model->attributeSet->name ?? '-'; }, 'filter' => Html::activeDropDownList($searchModel, 'attribute_set_id', \common\models\mall\AttributeSet::getIdLabel(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'star',
                        // 'sales',
                        // 'click',
                        ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypesLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypesLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status, true); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'created_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'updated_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        Html::actionsRedirect(),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->render('@backend/views/site/_filter', ['model' => $searchModel, 'dataProvider' => $dataProvider]) ?>
