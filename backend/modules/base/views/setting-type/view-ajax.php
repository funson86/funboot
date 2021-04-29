<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\base\SettingType as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\SettingType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setting Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card mt-2 setting-type-view">
    <div class="card-header">
        <?= $model->name ?>
    </div>

    <div class="card-body">

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
            'attributes' => [
                'id',
                'store_id',
                ['attribute' => 'parent_id', 'value' => function ($model) { return ActiveModel::getParentIdLabels($model->parent_id); }, ],
                'app_id',
                'name',
                'code',
                'brief',
                ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, ],
                'value_range',
                'value_default',
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
