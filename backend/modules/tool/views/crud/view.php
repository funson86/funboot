<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\tool\Crud as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\tool\Crud */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cruds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card crud-view">
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
                'name',
                'description',
                'time',
                'date',
                'started_at:datetime',
                'ended_at:datetime',
                'tag',
                'config',
                'image',
                'images',
                'file',
                'files',
                'markdown:ntext',
                'content:ntext',
                ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, ],
                'sort',
                ['attribute' => 'status', 'value' => function ($model) { return ActiveModel::getStatusLabels($model->status); }, ],
                'created_at:datetime',
                'updated_at:datetime',
                'created_by',
                'updated_by',
            ],
        ]) ?>

    </div>
</div>
