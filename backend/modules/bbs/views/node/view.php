<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\bbs\Node as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\bbs\Node */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card node-view">
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
                ['attribute' => 'parent_id', 'value' => function ($model) { return ActiveModel::getParentIdLabels($model->parent_id); }, ],
                'name',
                'surname',
                ['attribute' => 'is_nav', 'value' => function ($model) { return ActiveModel::getIsNavLabels($model->is_nav); }, ],
                'seo_title',
                'seo_keywords',
                'seo_description:ntext',
                'content:ntext',
                'redirect_url:url',
                'page_size',
                'template',
                'template_topic',
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
</div>
