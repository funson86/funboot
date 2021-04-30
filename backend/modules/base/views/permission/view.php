<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\base\Permission as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\Permission */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="permission-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-hover box'],
        'attributes' => [
            'id',
            'store_id',
            'parent_id',
            'name',
            'app_id',
            'brief',
            'path',
            'icon',
            'tree',
            'level',
            ['attribute' => 'target', 'value' => function ($model) { return ActiveModel::getTargetLabels($model->target); }, ],
            'type',
            'sort',
            ['attribute' => 'status', 'value' => function ($model) { return ActiveModel::getStatusLabels($model->status); }, ],
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
