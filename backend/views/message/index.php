<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\base\Message as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\Url;
use common\helpers\ArrayHelper;
use common\models\base\MessageType;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Message');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .summary {
        padding: 10px 15px;
    }
</style>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Yii::t('app', 'Folder') ?></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body p-0" style="display: block;">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item active">
                        <a href="<?= Url::to(['message/index', 'status' => 0], false, false) ?>" class="nav-link">
                            <i class="fas fa-inbox"></i> <?= Yii::t('cons', 'STATUS_UNREAD') ?><?= Yii::t('app', 'Message') ?>
                            <span class="badge bg-primary float-right"><?= $unread ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::to(['message/index', 'status' => 1], false, false) ?>" class="nav-link">
                            <i class="far fa-envelope"></i> <?= Yii::t('cons', 'STATUS_READ') ?><?= Yii::t('app', 'Message') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::to(['message/index', 'status' => -1], false, false) ?>" class="nav-link">
                            <i class="far fa-trash-alt"></i> <?= Yii::t('cons', 'STATUS_RECYCLE') ?>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card hidden-sm hidden-xs">
            <div class="card-header">
                <h3 class="card-title"><?= Yii::t('app', 'Label') ?></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-danger"></i> <?= Yii::t('app', 'Important') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-warning"></i> <?= Yii::t('app', 'Warning') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-primary"></i> <?= Yii::t('app', 'Normal') ?>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? ActiveModel::getStatusLabels(Yii::$app->request->get('status', 0)) . Html::encode($this->title) : Inflector::camelize($this->context->id);?></h2>
                <!--div class="card-tools">
                    <?= Html::createModal() ?>
                    <?= Html::export() ?>
                    <?= Html::import() ?>
                </div-->
            </div>
            <div class="card-body p-0">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => true,
                        ],

                        // 'id',
                        ['attribute' => 'id', 'label' => ' ', 'format' => 'raw', 'value' => function ($model) { return ($model->type == MessageType::TYPE_PRIVATE) ?  '<i class="fas fa-star text-warning"></i>' : ''; }, 'filter' => false],
                        // ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', ArrayHelper::map($this->context->getStores(), 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'user_id',
                        // 'from_id',
                        ['attribute' => 'from_id', 'value' => function ($model) { return $model->from->username; }, 'filter' => false],
                        // 'message_id',
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a($model->name, ['view', 'id' => $model->id], null, false);
                            },
                            'filter' => true,
                        ],
                        // 'content:ntext',
                        // 'type',
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        // ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return Html::status($model->status); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        [
                            'attribute' => 'created_at',
                            'label' => Yii::t('app', 'Time'),
                            'format' => 'raw',
                            'value' => function ($model) {
                                if (time() - $model->created_at < 86400) {
                                    return Yii::$app->formatter->asRelativeTime($model->created_at);
                                }
                                return Yii::$app->formatter->asDatetime($model->created_at);
                            },
                            'filter' => false,
                        ],
                        // 'updated_at:datetime',
                        // 'created_by',
                        // 'updated_by',

                        Html::actionsDelete(),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
