<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\base\MessageType as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\Message */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Message Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card mt-2 message-view">
    <div class="card-header">
        <?= $model->name ?>
    </div>

    <div class="card-body">

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
            'attributes' => [
                'id',
                ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name ?? '-'; }, ],
                'name',
                'content:ntext',
                'send_type',
                ['attribute' => 'send_target', 'value' => function ($model) { return ActiveModel::getSendTargetLabels($model->send_target); }, ],
                'send_user:ntext',
                ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, ],
                'sort',
                ['attribute' => 'status', 'value' => function ($model) { return ActiveModel::getStatusLabels($model->status, true); }, ],
                'created_at:datetime',
                'updated_at:datetime',
                ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],
            ],
        ]) ?>

    </div>
</div>
