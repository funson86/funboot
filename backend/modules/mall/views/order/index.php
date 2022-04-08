<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\mall\Order as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Orders');
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
                        ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->email; }, 'filter' => true],
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        'sn',
                        // 'country_id',
                        // 'province_id',
                        // 'city_id',
                        // 'district_id',
                        // 'state',
                        'address',
                        // 'address1',
                        // 'address2',
                        // 'zipcode',
                        'mobile',
                        'email:email',
                        // 'distance',
                        'remark',
                        // 'payment_method',
                        // 'payment_fee',
                        ['attribute' => 'payment_status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::getPaymentStatusLabels($model->payment_status); }, 'filter' => Html::activeDropDownList($searchModel, 'payment_status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'paid_at:datetime',
                        // 'shipment_id',
                        // 'shipment_name',
                        // 'shipment_fee',
                        // 'shipment_status',
                        ['attribute' => 'shipment_status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::getShipmentStatusLabels($model->shipment_status); }, 'filter' => Html::activeDropDownList($searchModel, 'shipment_status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'shipped_at:datetime',
                        // 'product_amount',
                        'amount',
                        // 'extra_fee',
                        // 'discount',
                        // 'tax',
                        // 'invoice',
                        // ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        // ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'created_at:datetime',
                        // 'updated_at:datetime',
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->username ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->username ?? '-'; }, ],

                        [
                            'header' => Yii::t('app', 'Actions'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {edit} {delete} {refund}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::view(['view', 'id' => $model->id], null, ['class' => 'btn btn-default btn-sm']);
                                },
                                'edit' => function ($url, $model, $key) {
                                    return Html::editModal(['edit-ajax', 'id' => $model->id]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::delete(['delete', 'id' => $model->id, 'soft' => true], Yii::t('app', 'Delete'));
                                },
                                'refund' => function ($url, $model, $key) {
                                    return $model->payment_method == ActiveModel::PAYMENT_METHOD_PAY && $model->payment_status == ActiveModel::PAYMENT_STATUS_PAID ? Html::buttonModal(['edit-status', 'id' => $model->id, 'status' => ActiveModel::PAYMENT_STATUS_REFUND], Yii::t('app', 'Refund'), ['class' => "btn btn-danger btn-sm"], false) : '';
                                },
                            ],
                            'headerOptions' => ['class' => 'action-column action-column-lg'],
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
