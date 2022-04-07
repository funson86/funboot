<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\base\Message as ActiveModel;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model common\models\base\Message */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card message-send-view">
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
                ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username ?? '-'; }, ],
                ['attribute' => 'message_type_id', 'value' => function ($model) { return $model->messageType->name ?? '-'; }, ],
                'name',
                [
                    'attribute' => 'content',
                    'format' => 'html',
                    'value' => function ($model) {
                        if ($model->content && strlen($model->content) > 0) {
                            if ($model->type == ActiveModel::TYPE_JSON) {
                                $content = json_decode($model->content, true);
                                return !is_array($content) ? $content : DetailView::widget([
                                    'model' => $content,
                                    'attributes' => array_keys($content),
                                ]);
                            } elseif ($model->type == ActiveModel::TYPE_MARKDOWN) {
                                return HtmlPurifier::process(Markdown::process($model->content, 'gfm'));
                            } else {
                                return $model->content;
                            }
                        } else {
                            return $model->messageType->content;
                        }
                    },
                ],
                ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, ],
                'sort',
                ['attribute' => 'status', 'value' => function ($model) { return ActiveModel::getStatusLabels($model->status, true); }, ],
                'created_at:datetime',
                'updated_at:datetime',
                ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->username ?? '-'; }, ],
                ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->username ?? '-'; }, ],
            ],
        ]) ?>

    </div>
</div>
