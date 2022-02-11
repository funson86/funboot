<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\bbs\Meta as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Metas');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language]['Metas'] ?? null) ?></h2>
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
                        // ['attribute' => 'parent_id', 'value' => function ($model) { return ActiveModel::getParentIdLabels($model->parent_id); }, 'filter' => Html::activeDropDownList($searchModel, 'parent_id', ActiveModel::getParentIdLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        'brief',
                        [
                            'label' => Yii::t('app', 'Children'),
                            'format' => 'raw',
                            'value' => function ($model) {
                                $arr = [];
                                foreach ($model->children as $item) {
                                    $str = $item->name . Html::a(' <i class="fa fa-edit"></i>', \common\helpers\Url::to(['edit', 'id' => $item->id]));

                                    // 3 level node
                                    $arrChild = [];
                                    foreach ($item->children as $child) {
                                        $arrChild[] = $child->name;
                                    }
                                    count($item->children) > 0 && $str .= '(' . implode(', ', $arrChild) . ')';
                                    $arr[] = $str;
                                }
                                return implode(', ', $arr);
                            },
                            'filter' => false,
                        ],
                        // 'type',
                        ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'created_at:datetime',
                        // 'updated_at:datetime',
                        // 'created_by',
                        // 'updated_by',

                        Html::actionsEditDelete(),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
