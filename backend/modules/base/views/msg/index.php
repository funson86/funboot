<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\base\Message as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->request->get('status');
$box = Yii::$app->request->get('box');
?>

<style>
    .grid-view th.action-column {
        min-width: 0;
    }
    table a {
        color: #333;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills ml-auto tab-nav">
                    <li class="nav-item"><a class="nav-link <?= !$status && !$box ? 'active' : '' ?>" href="<?= Url::to(['index']) ?>"><?= Yii::t('app', 'Inbox') ?></a></li>
                    <li class="nav-item"><a class="nav-link <?= $box ? 'active' : '' ?>" href="<?= Url::to(['index', 'box' => 'sent']) ?>"><?= Yii::t('app', 'Sent') ?></a></li>
                    <li class="nav-item"><a class="nav-link <?= $status == ActiveModel::STATUS_STAR && !$box ? 'active' : '' ?>" href="<?= Url::to(['index', 'status' => ActiveModel::STATUS_STAR]) ?>"><?= Yii::t('cons', 'STATUS_STAR') ?></a></li>
                    <li class="nav-item"><a class="nav-link <?= $status == ActiveModel::STATUS_DELETED && !$box ? 'active' : '' ?>" href="<?= Url::to(['index', 'status' => ActiveModel::STATUS_DELETED]) ?>"><?= Yii::t('cons', 'STATUS_RECYCLE') ?></a></li>
                </ul>
                <div class="card-tools">
                    <?= Html::create() ?>
                    <!--<?= Html::export() ?>
                    <?= Html::import() ?>-->
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

                        // 'id',
                        // ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', $this->context->getStoresIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'parent_id', 'value' => function ($model) { return $model->parent->name ?? '-'; }, 'filter' => Html::activeDropDownList($searchModel, 'parent_id', ActiveModel::getTreeIdLabel(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],,
                        // ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username ?? '-'; }, 'filter' => Html::activeDropDownList($searchModel, 'user_id', $this->context->getUsersIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],,
                        [
                            'visible' => Yii::$app->request->get('box') ? true : false,
                            'attribute' => 'user_id',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $icon = ($model->status == ActiveModel::STATUS_UNREAD) ?  '<i class="fa fa-envelope text-warning"></i> ' : '<i class="fa fa-envelope-open text-secondary"></i> ';
                                $model->status == ActiveModel::STATUS_STAR && $icon .= '<i class="fa fa-star text-warning"></i> ';
                                $option = ($model->status == ActiveModel::STATUS_UNREAD && !Yii::$app->request->get('box')) ? ['class' => 'text-bold'] : [];
                                return Html::a(
                                    $icon . $model->user->username,
                                    ['view', 'id' => $model->id],
                                    $option,
                                    false
                                );
                            },
                            'filter' => false
                        ],
                        [
                            'visible' => Yii::$app->request->get('box') ? false : true,
                            'attribute' => 'from_id',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $icon = ($model->status == ActiveModel::STATUS_UNREAD) ?  '<i class="fa fa-envelope text-warning"></i> ' : '<i class="fa fa-envelope-open text-secondary"></i> ';
                                $model->status == ActiveModel::STATUS_STAR && $icon .= '<i class="fa fa-star text-warning"></i> ';
                                $option = ($model->status == ActiveModel::STATUS_UNREAD && !Yii::$app->request->get('box')) ? ['class' => 'text-bold'] : [];
                                return Html::a(
                                    $icon . $model->from->username,
                                    ['edit', 'parent_id' => $model->id, 'user_id' => $model->from_id],
                                    $option,
                                    false
                                );
                            },
                            'filter' => false
                        ],
                        // 'message_type_id',
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $option = ($model->status == ActiveModel::STATUS_UNREAD && !Yii::$app->request->get('box')) ? ['class' => 'text-bold'] : [];
                                $url = Yii::$app->request->get('box') ? ['view', 'id' => $model->id] : ['edit', 'parent_id' => $model->id, 'user_id' => $model->from_id];
                                return Html::a($model->name, $url, $option, false);
                            },
                            'filter' => true,
                        ],
                        // 'content:ntext',
                        // ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        // ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status, true); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        [
                            'attribute' => 'created_at',
                            'label' => Yii::t('app', 'Time'),
                            'format' => 'raw',
                            'value' => function ($model) {
                                $str = (time() - $model->created_at < 2 * 86400) ? Yii::$app->formatter->asRelativeTime($model->created_at) : Yii::$app->formatter->asDatetime($model->created_at);
                                $option = ($model->status == ActiveModel::STATUS_UNREAD && !Yii::$app->request->get('box')) ? ['class' => 'text-bold'] : [];
                                $url = Yii::$app->request->get('box') ? ['view', 'id' => $model->id] : ['edit', 'parent_id' => $model->id, 'user_id' => $model->from_id];
                                return Html::a($str, $url, $option, false);
                            },
                            'filter' => false,
                        ],
                        // 'updated_at:datetime',
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        // Html::actionsModal(),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
