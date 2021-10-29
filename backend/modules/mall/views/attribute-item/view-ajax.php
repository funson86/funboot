<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\mall\AttributeItem as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\mall\AttributeItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attribute Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body attribute-item-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
        'attributes' => [
            'id',
            ['attribute' => 'store_id', 'value' => function ($model) { return ActiveModel::getStoreIdLabels($model->store_id); }, ],
            ['attribute' => 'attribute_id', 'value' => function ($model) { return ActiveModel::getAttributeIdLabels($model->attribute_id); }, ],
            'name',
            'brief',
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
