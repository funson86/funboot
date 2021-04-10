<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\bbs\Comment as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\bbs\Comment */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body comment-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
        'attributes' => [
            'id',
            'store_id',
            'parent_id',
            ['attribute' => 'topic_id', 'value' => function ($model) { return ActiveModel::getTopicIdLabels($model->topic_id); }, ],
            ['attribute' => 'user_id', 'value' => function ($model) { return ActiveModel::getUserIdLabels($model->user_id); }, ],
            'name',
            'content:ntext',
            'like',
            'ip',
            'ip_info',
            'type',
            ['attribute' => 'sort', 'value' => function ($model) { return ActiveModel::getSortLabels($model->sort); }, ],
            'status',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
