<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\base\Message as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\Url;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/base/message-type/index']) ?>"><?= Yii::t('app', 'Message Type') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?></a>
                    </li>
                    <li class="nav-tabs-tools">
                        <!--<?= Html::export() ?>-->
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

                        // 'id',
                        ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', ArrayHelper::map($this->context->getStores(), 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'store_id', 'value' => function ($model) { return $model->store->name; }, 'filter' => true],
                        // ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username ?? '-'; }, 'filter' => Html::activeDropDownList($searchModel, 'user_id', $this->context->getUsersIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],,
                        ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username; }, 'filter' => true],
                        ['attribute' => 'from_id', 'value' => function ($model) { return $model->from->username; }, 'filter' => true],
                        // 'message_type_id',
                        'name',
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        // ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $class = $model->status == ActiveModel::STATUS_READ ? 'btn-success' : 'btn-default';
                                return Html::tag('span', ActiveModel::getStatusLabels($model->status), ['class' => 'btn btn-xs ' . $class]);
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),
                        ],
                        'created_at:datetime',
                        // 'updated_at:datetime',
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        Html::actionsCustom(['view']),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
