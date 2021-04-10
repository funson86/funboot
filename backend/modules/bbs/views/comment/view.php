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
<div class="card comment-view">
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
</div>
