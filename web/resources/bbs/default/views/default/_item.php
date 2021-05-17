<?php
use common\models\bbs\Topic as ActiveModel;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var  ActiveModel $model */
?>

<div class="media text-muted">
    <div class="bd-placeholder-img mr-3">
        <img class="rounded-circle" src="<?= $model->user->getMixedAvatar() ?>" />
    </div>

    <div class="media-body small lh-125 border-gray">
        <div class="media-heading topic-title"><?= Html::a($model->name, ['/bbs/topic/view', 'id' => $model->id]) ?><?= $model->status == ActiveModel::STATUS_INACTIVE ? ' ' . Html::tag('span', Yii::t('app', 'Unverified'), ['class' => 'btn-warning pl-1 pr-1']) : $model->status ?> </div>
        <div class="topic-info">
            <a class="remove-padding-left" href="<?= Url::to(['/bbs/topic/view', 'id' => $model->id]) ?>"><span class="bi-hand-thumbs-up"> <?= $model->like ?> </span></a> •
            <a class="topic-node" href="<?= Url::to(['/bbs/default/index', 'id' => $model->node_id]) ?>"><?= $model->node->name ?></a> •
            <span>最后由<a href="<?= Url::to(['/bbs/user/view', 'id' => $model->last_comment_user_id]) ?>"><strong> <?= $model->last_comment_username ?> </strong></a>于 <?= Yii::$app->formatter->asDate($model->last_comment_updated_at) ?> •
            <?= $model->click ?> 次阅读
        </div>
    </div>
</div>


