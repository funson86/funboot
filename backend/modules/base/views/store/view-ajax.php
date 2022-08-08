<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\Store as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body store-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
        'attributes' => [
            'id',
            ['attribute' => 'parent_id', 'value' => function ($model) { return $model->parent->name ?? '-'; }, ],
            ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username ?? '-'; }, ],
            'name',
            'brief',
            'host_name',
            'code',
            'qrcode',
            'route',
            'expired_at:datetime',
            'remark:ntext',
            'language',
            'lang_source',
            'lang_frontend',
            'lang_frontend_default',
            'lang_backend',
            'lang_backend_default',
            'lang_api',
            'lang_api_default',
            'fund',
            'fund_amount',
            'billable_fund',
            'income',
            'income_amount',
            'income_count',
            'consume_count',
            'consume_amount',
            'history_amount',
            'param1',
            'param2',
            'param3',
            'param4',
            'param5',
            'param6',
            'grade',
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
