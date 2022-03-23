<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\base\MessageType as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\Url;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Message Types');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/message/index']) ?>"><?= Yii::t('app', 'Message') ?></a>
                    </li>
                    <li class="nav-tabs-tools">
                        <?= Html::createModal(['edit-ajax'], null, ['class' => 'btn btn-primary btn-xs']) ?>
                        <!--<?= Html::export() ?>-->
                        <?= Html::import(null, null, ['class' => 'btn btn-success btn-xs']) ?>
                    </li>
                </ul>
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
                        'name',
                        //['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        // 'content:ntext',
                        ['attribute' => 'send_type', 'value' => function ($model) { return ActiveModel::getSendTypeLabels($model->send_type); }, 'filter' => Html::activeDropDownList($searchModel, 'send_type', ActiveModel::getSendTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'send_target', 'value' => function ($model) { return ActiveModel::getSendTargetLabels($model->send_target); }, 'filter' => Html::activeDropDownList($searchModel, 'send_target', ActiveModel::getSendTargetLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'send_user:ntext',
                        ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'created_at:datetime',
                        // 'updated_at:datetime',
                        // 'created_by',
                        // 'updated_by',

                        [
                            'header' => Yii::t('app', 'Actions'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {edit} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::buttonModal(['/base/message/index', 'message_type_id' => $model->id], Yii::t('app', 'View'), ['class' => 'btn btn-sm btn-default'], false);
                                },
                                'edit' => function ($url, $model, $key) {
                                    return Html::editModal(['edit-ajax', 'id' => $model->id]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::delete(['delete', 'id' => $model->id], Yii::t('app', 'Delete&Withdraw'));
                                },
                            ],
                            'options' => ['class' => 'operation'],
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
