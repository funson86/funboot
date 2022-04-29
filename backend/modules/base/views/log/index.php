<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\base\Log as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\Url;
use common\helpers\ArrayHelper;
use common\components\base\LogSystem;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */
/* @var int $type */

$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills ml-auto tab-nav">
                    <?php foreach (ActiveModel::getTypeLabels() as $k => $v) { ?>
                        <li class="nav-item"><a class="nav-link<?= $type == $k ? ' active' : '' ?>" href="<?= Url::to(['index', 'type' => $k]) ?>"><?= $v ?></a></li>
                    <?php } ?>
                </ul>
                <div class="card-tools">
                    <?= Html::export() ?>
                    <?= Html::buttonModal(['stat-ajax-error'], Yii::t('app', 'Error') . Yii::t('app', 'Stat Report'), ['size' => 'Max', 'class' => 'btn btn-default btn-sm']) ?>
                    <?= Html::buttonModal(['stat-ajax-login'], Yii::t('app', 'Login') . Yii::t('app', 'Stat Report'), ['size' => 'Max', 'class' => 'btn btn-default btn-sm']) ?>
                </div>
            </div>

            <?php if (Yii::$app->logSystem->driver == LogSystem::DRIVER_MYSQL) { ?>

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
                        // ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', $this->context->getStoresIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username ?? '-'; }, 'filter' => Html::activeDropDownList($searchModel, 'user_id', $this->context->getUsersIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],,
                        'name',
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        'url:url',
                        ['attribute' => 'method', 'value' => function ($model) { return ActiveModel::getMethodLabels($model->method); }, 'filter' => Html::activeDropDownList($searchModel, 'method', ActiveModel::getMethodLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'params:ntext',
                        // 'user_agent',
                        // ['attribute' => 'agent_type', 'value' => function ($model) { return ActiveModel::getAgentTypeLabels($model->agent_type); }, 'filter' => Html::activeDropDownList($searchModel, 'agent_type', ActiveModel::getAgentTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'ip',
                        'ip_info',
                        [
                            'attribute' => 'code',
                            'value' => function ($model) {
                                return $model->code;
                            },
                            'filter' => true,
                            'visible' => intval($type) != ActiveModel::TYPE_OPERATION,
                        ],
                        [
                            'attribute' => 'code',
                            'value' => function ($model) {
                                return ActiveModel::getCodeLabels($model->code);
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'code', ActiveModel::getCodeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),
                            'visible' => intval($type) == ActiveModel::TYPE_OPERATION,
                        ],
                        'msg',
                        // 'data:ntext',
                        'cost_time',
                        /*[
                            'attribute' => 'type',
                            'value' => function ($model) {
                                return ActiveModel::getTypeLabels($model->type);
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),
                            'visible' => intval(Yii::$app->request->get('id')) == 1,
                        ],*/
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        // ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'created_at:datetime',
                        // 'updated_at:datetime',
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        [
                            'header' => Yii::t('app', 'Actions'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::buttonModal(['view-ajax', 'id' => $model->id], Yii::t('app', 'View'), ['size' => 'Max', 'class' => 'btn btn-default btn-sm']);
                                },
                            ],
                            //'visible' => $type != ActiveModel::TYPE_LOGIN,
                            'options' => ['class' => 'operation'],
                        ],
                    ]
                ]); ?>
            </div>

            <?php } elseif (Yii::$app->logSystem->driver == LogSystem::DRIVER_MONGODB) { ?>

            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?= Yii::t('app', 'Name') ?></th>
                        <th><?= Yii::t('app', 'Url') ?></th>
                        <th><?= Yii::t('app', 'Method') ?></th>
                        <th><?= Yii::t('app', 'Ip') ?></th>
                        <th><?= Yii::t('app', 'Ip Info') ?></th>
                        <th><?= Yii::t('app', 'Code') ?></th>
                        <th><?= Yii::t('app', 'Msg') ?></th>
                        <th><?= Yii::t('app', 'Cost Time') ?></th>
                        <th><?= Yii::t('app', 'Created At') ?></th>
                        <th><?= Yii::t('app', 'Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($models as $model) { ?>
                        <tr id="<?= $model['_id'] ?>">
                            <td><?= $model['_id'] ?></td>
                            <td><?= $model['name'] ?></td>
                            <td><?= $model['url'] ?></td>
                            <td><?= $model['method'] ?></td>
                            <td><?= $model['ip'] ?></td>
                            <td><?= $model['ip_info'] ?></td>
                            <td><?= $model['code'] ?></td>
                            <td><?= $model['msg'] ?></td>
                            <td><?= $model['cost_time'] ?></td>
                            <td><?= date('Y-m-d H:i:s', $model['created_at']) ?></td>
                            <td>
                                <?= Html::delete(['delete', 'id' => $model['_id']]); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <p>
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $pages
                ]);?>
                </p>
            </div>
            <?php } ?>

        </div>
    </div>
</div>

