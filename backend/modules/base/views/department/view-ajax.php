<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\base\Department as ActiveModel;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\base\Department */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body department-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
        'attributes' => [
            'id',
            ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name ?? '-'; }, ],
            ['attribute' => 'parent_id', 'value' => function ($model) { return $model->parent->name ?? '-'; }, ],
            'name',
            'app_id',
            'brief',
            [
                'attribute' => 'head',
                'value' => function ($model) {
                    $list = [];
                    $arr = explode('|', $model->head);
                    foreach ($arr as $userId) {
                        $user = User::findOne($userId);
                        $list[] = $user->username ?? '';
                    }
                    return implode('|', $list);
                },
            ],
            [
                'attribute' => 'vice_head',
                'value' => function ($model) {
                    $list = [];
                    $arr = explode('|', $model->vice_head);
                    foreach ($arr as $userId) {
                        $user = User::findOne($userId);
                        $list[] = $user->username ?? '';
                    }
                    return implode('|', $list);
                },
            ],
            'level',
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
