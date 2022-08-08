<?php
use yii\widgets\Menu;

$user = Yii::$app->user->identity;
$name = $user->name ?: $user->email;
?>

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
        <?= \yii\helpers\Html::img($user->getMixedAvatar(24), ['class' => 'rounded-circle', 'alt' => $name, 'width' => 24, 'height' => 24]);?>
        <?= $name ?>
        </h6>
    </div>
    <div class="card-body">
        <?= Menu::widget([
            'options' => [
                'class' => 'list-group list-group-flush'
            ],
            'items' => [
                ['label' => Yii::t('app', 'Profile'),  'url' => ['/bbs/user/profile'], 'options' => ['class' => 'list-group-item']],
                ['label' => Yii::t('app', 'Avatar'),  'url' => ['/bbs/user/avatar'], 'options' => ['class' => 'list-group-item']],
                ['label' => Yii::t('app', 'Change Password'),  'url' => ['/bbs/user/change-password'], 'options' => ['class' => 'list-group-item']],
            ]
        ]) ?>
    </div>
</div>
