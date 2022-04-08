<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\Store as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ImageHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Stores');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->module->id . '_' . $this->context->id] ?? null) ?></h2>
                <div class="card-tools">
                    <?= Html::buttonModal(['edit-maintain-all'], Yii::t('app', 'Maintain All'), ['class' => 'btn btn-sm btn-danger'], false) ?>
                    <?= Html::buttonModal(['edit-maintain-cancel'], Yii::t('app', 'Cancel Maintenance'), ['class' => 'btn btn-sm btn-success'], false) ?>
                    <?= Html::createModal(['edit-ajax'], null, ['size' => 'Large']) ?>
                    <?= Html::buttonModal(['edit-config'], Yii::t('app', 'Refresh Config File'), ['class' => 'btn btn-sm btn-warning'], false) ?>
                    <?= Html::buttonModal(['edit-qrcode'], Yii::t('app', 'Refresh Qrcode'), ['class' => 'btn btn-sm btn-info'], false) ?>
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
                        ['attribute' => 'parent_id', 'value' => function ($model) { return $model->parent ? $model->parent->host_name : '-'; }, ],
                        // 'host_name',
                        ['attribute' => 'host_name', 'format' => 'raw', 'value' => function ($model) { return $model->parent_id > 0 ? '<i class="fa fa-star"></i>' . $model->parent->host_name . '<br>' . $model->host_name : $model->host_name; }, 'filter' => true],
                        'code',
                        ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username; }, 'filter' => true],
                        'name',
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        'brief',
                        // 'host_name',
                        ['attribute' => 'qrcode', 'filter' => false, 'format' => 'raw', 'value' => function ($model) { return ImageHelper::fancyBox($model->qrcode); },],
                        //'route',
                        ['attribute' => 'route', 'value' => function ($model) { return ActiveModel::getRouteLabels($model->route); }, 'filter' => Html::activeDropDownList($searchModel, 'route', ActiveModel::getRouteLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'remark:ntext',
                        ['attribute' => 'lang_frontend', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::getLanguageLabels($model->lang_frontend); }, 'filter' => false,],
                        ['attribute' => 'lang_frontend_default', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::getLanguageCodeLabels($model->lang_frontend_default); }, 'filter' => false,],
                        'consume_count',
                        'consume_amount',
                        'history_amount',
                        // ['attribute' => 'type', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => false,],
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return Html::color($model->status, ActiveModel::getStatusLabels($model->status), [ActiveModel::STATUS_ACTIVE], [ActiveModel::STATUS_INACTIVE], [ActiveModel::STATUS_MAINTENANCE], [ActiveModel::STATUS_DELETED]); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(null, true), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'expired_at:datetime',
                        'created_at:datetime',
                        // 'updated_at:datetime',
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->username ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->username ?? '-'; }, ],

                        [
                            'header' => Yii::t('app', 'Actions'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{login} {go} {setting} {renew} {sub} {edit} {delete}',
                            'buttons' => [
                                'login' => function ($url, $model, $key) {
                                    return Html::buttonModal(['login', 'id' => $model->id], Yii::t('app', 'Login'), ['class' => 'btn btn-sm btn-success'], false, true);
                                },
                                'go' => function ($url, $model, $key) {
                                    return Html::buttonModal(['go', 'id' => $model->id], Yii::t('app', 'Go'), ['class' => 'btn btn-sm btn-info'], false, true);
                                },
                                'setting' => function ($url, $model, $key) {
                                    return Html::edit(['setting/edit-all', 'store_id' => $model->id], Yii::t('app', 'Setting'), ['class' => 'btn btn-sm btn-primary']);
                                },
                                'renew' => function ($url, $model, $key) {
                                    return Html::editModal(['edit-renew', 'id' => $model->id], Yii::t('app', 'Renew'), ['class' => 'btn btn-sm btn-success']);
                                },
                                'sub' => function ($url, $model, $key) {
                                    return $model->parent_id == 0 ? Html::editModal(['edit-ajax', 'parent_id' => $model->id], Yii::t('app', 'Sub'), ['size' => 'Large', 'class' => 'btn btn-sm btn-info']) : '';
                                },
                                'edit' => function ($url, $model, $key) {
                                    return Html::editModal(['edit-ajax', 'id' => $model->id], null, ['size' => 'Large']);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::delete(['delete', 'id' => $model->id]);
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
