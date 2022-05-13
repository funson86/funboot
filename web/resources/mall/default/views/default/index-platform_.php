<?php
use common\models\bbs\Topic as ActiveModel;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var  ActiveModel $model */
?>

<div class="media text-muted">
    <div class="bd-placeholder-img mr-3">
        <img class="rounded-circle" src="<?= $model->qrcode ?: $model->user->getMixedAvatar() ?>" width="50" height="50" />
    </div>

    <div class="media-body small lh-125 border-gray">
        <div class="media-heading topic-title"><?= Html::a($model->name, 'store-' . $model->code) ?></div>
        <div class="topic-info">
            <?= $model->brief ?>
        </div>
    </div>
</div>


