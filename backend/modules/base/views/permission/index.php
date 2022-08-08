<?php

use jianyan\treegrid\TreeGrid;
use common\helpers\Html;
use yii\helpers\Inflector;
use common\models\base\Permission as ActiveModel;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Permissions');
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
                <?= \jianyan\treegrid\TreeGrid::widget([
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
                            'class' => 'yii\grid\CheckboxColumn',
                            'visible' => false,
                        ],

                        // 'id',
                        //  ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', $this->context->getStoresIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],,
                        // 'parent_id',
                        // 'name',
                        // 'app_id',
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                $icon = Html::tag('i', '', ['class' => $model->icon]);
                                $str = Html::tag('span', $icon . ' ' . $model->name, ['class' => 'm-l-sm']);
                                if ($model->level < 4) {
                                    $str .= Html::a(' <i class="fa fa-plus"></i>', ['edit-ajax', 'parent_id' => $model['id']], [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#ajaxModal',
                                    ]);
                                }
                                return Html::tag('span', $str);
                            }
                        ],
                        // 'brief',
                        // 'path',
                        // 'icon',
                        // 'tree',
                        // 'level',
                        // ['attribute' => 'target', 'value' => function ($model) { return ActiveModel::getTargetLabels($model->target); }, 'filter' => Html::activeDropDownList($searchModel, 'target', ActiveModel::getTargetLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'sort',
                        ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }],
                        // ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status, true); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(null, true), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'created_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'updated_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        Html::actionsModal(['tree' => true]),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
