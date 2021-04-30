<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ListView;
use common\models\User;
use yii\helpers\Url;
?>
<section class="container user-default-index">

    <!--/col-3-->
    <div class="col-sm-9 list-nav mb20" contenteditable="false" style="">
        <nav class="navbar navbar-default">
            <?= \yii\bootstrap4\Nav::widget([
                'options' => [
                    'class' => 'nav nav-pills',
                ],
                'items' => [
                    ['label' => '最新回复',  'url' => ['/bbs/user/view', 'id'=> $model->id, 'type' => 'index']],
                    ['label' => '最新主题',  'url' => ['/bbs/user/view', 'id'=> $model->id, 'type' => 'topic']],
                    ['label' => '最新收藏',  'url' => ['/bbs/user/view', 'id'=> $model->id, 'type' => 'favorite']],
                    ['label' => '最新赞过主题',  'url' => ['/bbs/user/view', 'id'=> $model->id, 'type' => 'like']],
                    // ['label' => '积分动态',  'url' => ['/bbs/user/view', 'id'=> $model->id, 'type' => 'point']],
                ]
            ]) ?>
        </nav>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item'],
            'summary' => false,
            'itemView' => '_view',
            'options' => ['class' => 'list-group'],
        ]) ?>
    </div>
</section>
