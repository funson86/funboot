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
<div class="card store-view">
    <div class="card-header">
        <?= Html::a(Yii::t('app', 'Update'), ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="card-body">

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-hover box'],
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
</div>
