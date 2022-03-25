<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\base\Message as ActiveModel;
use yii\helpers\Markdown;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model common\models\base\Message */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
\yii\web\YiiAsset::register($this);
?>
<div class="card message-view">
    <!--div class="card-header">
        <?= Html::a('<i class="fa fa-reply"></i> ' . Yii::t('app', 'Reply'), ['edit', 'parent_id' => $model->id, 'user_id' => $model->from_id], ['class' => 'btn btn-primary mr-3']) ?>
        <?= Html::a('<i class="fa fa-star"></i> ' . Yii::t('cons', 'STATUS_STAR'), ['edit-status', 'id' => $model->id, 'status' => ActiveModel::STATUS_STAR], ['class' => 'btn btn-dark text-warning mr-3']) ?>
        <?= Html::a('<i class="fa fa-trash"></i> ' . Yii::t('cons', 'STATUS_RECYCLE'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <div class="card-tools pt-1">
            <?= $model->status == ActiveModel::STATUS_STAR ? '<i class="fa fa-star text-warning text-lg"></i>' : '' ?>
            <?= $model->status == ActiveModel::STATUS_DELETED ? '<i class="fa fa-trash text-danger text-lg"></i>' : '' ?>
        </div>
    </div-->

    <div class="card-body">
        <p class="text-secondary"><?= $model->from->username ?> <?= Yii::$app->formatter->asDatetime($model->created_at) ?></p>
        <h5><?= $model->name ?></h5>
        <?php
        if ($model->content && strlen($model->content) > 0) {
            if ($model->type == ActiveModel::TYPE_JSON) {
                $content = json_decode($model->content, true);
                echo !is_array($content) ? $content : DetailView::widget([
                    'model' => $content,
                    'attributes' => array_keys($content),
                ]);
            } elseif ($model->type == ActiveModel::TYPE_MARKDOWN) {
                echo HtmlPurifier::process(Markdown::process($model->content, 'gfm'));
            } else {
                echo $model->content;
            }
        } else {
            echo $model->messageType->content;
        }
        ?>

        <?php if ($model->parent_id > 0) { $parent = $model->parent; while ($parent) { ?>
        <div class="pt-1">
            <hr>
            <p class="text-secondary"><?= $parent->from->username ?> <?= Yii::$app->formatter->asDatetime($parent->created_at) ?></p>
            <h6><?= $parent->name ?></h6>
            <?php
            if ($parent->content && strlen($parent->content) > 0) {
                if ($parent->type == ActiveModel::TYPE_JSON) {
                    $content = json_decode($parent->content, true);
                    echo !is_array($content) ? $content : DetailView::widget([
                        'model' => $content,
                        'attributes' => array_keys($content),
                    ]);
                } elseif ($parent->type == ActiveModel::TYPE_MARKDOWN) {
                    echo HtmlPurifier::process(Markdown::process($parent->content, 'gfm'));
                } else {
                    echo $parent->content;
                }
            } else {
                echo $parent->messageType->content;
            }
            ?>
        </div>
        <?php $parent = $parent->parent; } } ?>
    </div>
</div>
