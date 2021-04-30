<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\mall\Rank as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Rank */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ranks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body rank-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
        'attributes' => [
            'id',
            'store_id',
            'product_id',
            'name',
            'order_id',
            'star',
            'content:ntext',
            'point',
            'up',
            'type',
            'sort',
            ['attribute' => 'status', 'value' => function ($model) { return ActiveModel::getStatusLabels($model->status); }, ],
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
