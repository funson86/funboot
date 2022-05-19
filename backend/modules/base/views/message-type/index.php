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
                        <a class="nav-link" href="<?= Url::to(['/base/message/index']) ?>"><?= Yii::t('app', 'Message') ?></a>
                    </li>
                    <li class="nav-tabs-tools">
                        <?= Html::filterModal() ?>
                        <?= Html::createModal(['edit-ajax'], null, ['class' => 'btn btn-primary btn-xs']) ?>
                        <!--<?= Html::export() ?>-->
                        <?= Html::import(null, null, ['class' => 'btn btn-success btn-xs']) ?>
                    </li>
                </ul>
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
                        'name',
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        // 'content:ntext',
                        ['attribute' => 'send_type', 'value' => function ($model) { return ActiveModel::getSendTypeLabels($model->send_type); }, 'filter' => Html::activeDropDownList($searchModel, 'send_type', ActiveModel::getSendTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'send_target', 'value' => function ($model) { return ActiveModel::getSendTargetLabels($model->send_target); }, 'filter' => Html::activeDropDownList($searchModel, 'send_target', ActiveModel::getSendTargetLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'send_user:ntext',
                        ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status, true); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'created_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'updated_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        [
                            'header' => Yii::t('app', 'Actions'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => ' {view-message} {view} {edit} {delete}',
                            'buttons' => [
                                'view-message' => function ($url, $model, $key) {
                                    return Html::buttonModal(['/base/message/index', 'message_type_id' => $model->id], Yii::t('app', 'View ') . Yii::t('app', 'Message'), ['class' => 'btn btn-sm btn-info'], false);
                                },
                                'view' => function ($url, $model, $key) {
                                    return Html::viewModal(['view-ajax', 'id' => $model->id]);
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

<?= $this->render('@backend/views/site/_filter', ['model' => $searchModel, 'dataProvider' => $dataProvider]) ?>
