<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\bbs\Node as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;
use jianyan\treegrid\TreeGrid;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Nodes');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->module->id . '_' . $this->context->id] ?? null) ?></h2>
                <div class="card-tools">
                    <?= Html::createModal() ?>
                    <?= Html::export() ?>
                    <?= Html::import() ?>
                </div>
            </div>
            <div class="card-body">
                <?= TreeGrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'parent_id',
                    'parentRootValue' => '0', //first parentId value
                    'pluginOptions' => [
                        'initialState' => 'collapsed',
                    ],
                    'options' => ['class' => 'table table-hover tab-treegrid'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => false,
                        ],

                        // 'id',
                        // ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', ArrayHelper::map($this->context->getStores(), 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'parent_id', 'value' => function ($model) { return ActiveModel::getParentIdLabels($model->parent_id); }, 'filter' => Html::activeDropDownList($searchModel, 'parent_id', ActiveModel::getParentIdLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'parent_id', 'value' => function ($model) { return $model->parent->name ?? '-'; }, 'filter' => Html::activeDropDownList($searchModel, 'parent_id', ActiveModel::getTreeIdLabel(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],,
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                $str = Html::tag('span', $model->name, ['class' => 'm-l-sm']);
                                $str .= Html::a(' <i class="fa fa-plus"></i>', ['edit', 'parent_id' => $model['id']]);
                                return Html::tag('span', $str);
                            }
                        ],
                        ['attribute' => 'is_nav', 'value' => function ($model) { return YesNo::getLabels($model->is_nav); }],
                        ['attribute' => 'meta_id', 'value' => function ($model) { return $model->meta->name ?? '-'; }],
                        // 'surname',
                        // ['attribute' => 'is_nav', 'value' => function ($model) { return YesNo::getLabels($model->is_nav); }, 'filter' => Html::activeDropDownList($searchModel, 'is_nav', YesNo::getLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'seo_title',
                        // 'seo_keywords',
                        // 'seo_description:ntext',
                        // 'content:ntext',
                        // 'redirect_url:url',
                        // 'page_size',
                        // 'template',
                        // 'template_topic',
                        // ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status); }],
                        // 'created_at:datetime',
                        // 'updated_at:datetime',
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        Html::actionsModal(),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
