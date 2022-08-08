<?php
use common\models\bbs\Topic as ActiveModel;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var  ActiveModel $model */
?>

<div class="media text-muted">
    <div class="bd-placeholder-img mr-3">
        <img class="rounded-circle" src="<?= $model->user_avatar ?: $model->user->getMixedAvatar() ?>" width="50" height="50" />
    </div>

    <div class="media-body small lh-125 border-gray">
        <div class="media-heading topic-title"><?= $model->grade == ActiveModel::GRADE_EXCELLENT ? Html::tag('span', '精', ['class' => 'badge badge-pill badge-info']) : '' ?><?= Html::a($model->name, ['/bbs/topic/view', 'id' => $model->id]) ?><?= $model->status == ActiveModel::STATUS_INACTIVE ? ' ' . Html::tag('span', Yii::t('app', 'Unverified'), ['class' => 'btn-warning pl-1 pr-1']) . ' ' . Html::a(Yii::t('app', 'Pass'), ['/bbs/topic/pass', 'id' => $model->id], ['class' => 'btn btn-sm btn-success']) . ' ' . Html::a(Yii::t('app', 'Delete'), ['/bbs/topic/delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger']) : '' ?> </div>
        <div class="topic-info">
            <a class="remove-padding-left" href="<?= Url::to(['/bbs/topic/view', 'id' => $model->id]) ?>"><span class="fa fa-thumbs-o-up"> <?= $model->like ?> </span></a> •
            <a class="topic-node" href="<?= Url::to(['/bbs/default/index', 'id' => $model->node_id]) ?>"><?= $model->node->name ?></a> •
            <?php if ($model->comment > 0) { ?>
            <span>最后由 <a href="<?= Url::to(['/bbs/user/view', 'id' => $model->last_comment_user_id]) ?>"><strong> <?= $model->last_comment_username ?> </strong></a>于 <?= Yii::$app->formatter->asDate($model->last_comment_updated_at) ?> 回复 •
            <?php } else { ?>
            <span>由 <a href="<?= Url::to(['/bbs/user/view', 'id' => $model->user_id]) ?>"><strong> <?= $model->username ?> </strong></a>于 <?= Yii::$app->formatter->asDate($model->created_at) ?> 发布 •
            <?php } ?>
            <?= $model->click ?> 次阅读
        </div>
    </div>
</div>


