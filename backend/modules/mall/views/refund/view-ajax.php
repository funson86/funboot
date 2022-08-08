<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\mall\Refund as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Refund */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Refunds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body refund-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
        'attributes' => [
            'id',
            ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name ?? '-'; }, ],
            ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username ?? '-'; }, ],
            'order_id',
            'name',
            'brief',
            'amount',
            'remark',
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
