<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\base\Attachment as ActiveModel;
use common\helpers\ImageHelper;

/* @var $this yii\web\View */
/* @var $model common\models\base\Attachment */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attachments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card attachment-view">
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
                ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name ?? '-'; }, ],
                'name',
                'driver',
                ['attribute' => 'upload_type', 'value' => function ($model) { return ActiveModel::getUploadTypeLabels($model->upload_type); }, ],
                'file_type',
                'path',
                [
                    'attribute' => 'url',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (($model['upload_type'] == ActiveModel::UPLOAD_TYPE_IMAGE || preg_match("/^image/", $model['file_type'])) && $model['ext'] != 'psd') {
                            return ImageHelper::fancyBox($model->url);
                        }
                        return Html::a(Yii::t('app', 'Preview'), $model->url, [
                            'target' => '_blank'
                        ]);
                    },
                ],
                'md5',
                'size',
                'ext',
                'year',
                'month',
                'day',
                'width',
                'height',
                'ip',
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
