<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\base\Recharge as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Recharges');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->module->id . '_' . $this->context->id] ?? null) ?></h2>
                <div class="card-tools">
                    <?= Html::create(['edit-new'], Yii::t('app', 'Recharge')) ?>
                    <?= Html::export() ?>
                    <!--<?= Html::import() ?>-->
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
                        ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', $this->context->getStoresIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username ?? '-'; }, 'filter' => Html::activeDropDownList($searchModel, 'user_id', $this->context->getUsersIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'name',
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        // 'sn',
                        // 'mobile',
                        // 'email:email',
                        'remark',
                        // 'payment_method',
                        'amount',
                        ['attribute' => 'payment_status', 'format' => 'raw', 'value' => function ($model) { return \common\helpers\Html::color($model->payment_status, ActiveModel::getPaymentStatusLabels($model->payment_status), [ActiveModel::PAYMENT_STATUS_PAID], [ActiveModel::PAYMENT_STATUS_UNPAID], [], [ActiveModel::PAYMENT_STATUS_REFUND]); }, 'filter' => Html::activeDropDownList($searchModel, 'payment_status', ActiveModel::getPaymentStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'paid_at', 'value' => function ($model) { return $model->paid_at > 0 ? Yii::$app->formatter->asDatetime($model->paid_at) : '-'; }, ],
                        // 'tax',
                        // 'invoice',
                        // ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        // ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status, true); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'created_at:datetime',
                        // 'updated_at:datetime',
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        Html::actionsView(),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
