<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ListView;
use common\models\User;
use yii\helpers\Url;

$this->title = Html::encode($model->username);
?>
<section class="container user-default-index">

    <div class="row pb-5">
    <!--/col-3-->
    <div class="col-sm-3">
        <!--left col-->
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-left media-middle">
                        <?= Html::img($model->getMixedAvatar(), ['class' => 'rounded-circle', 'width' => 50, 'height' => 50]) ?>
                    </div>
                    <div class="media-body ml-3">
                        <h6 class="mt5"><?= Html::tag('strong', Html::encode($model->username)) ?></h6>
                        <div class="pull-left">
                            <span class="badge badge-success"><?= $model->isBbsManager() ?  Yii::t('app', 'Manager') : Yii::t('app', 'Member') ?></span>
                            <?= $this->context->isManager() ? Html::a(Yii::t('app', 'Black List'), ['/bbs/user/black-list', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger']) : '' ?>
                        </div>
                    </div>
                </div>

                <hr class="mb-3 mt-3" />

                <div class="row">
                    <div class="col-sm-6 text-center">
                        <h3><?= $model->profile->like ?? 0 ?></h3>
                        <div><?= Yii::t('app', 'Like') ?></div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <h3><?= $model->profile->thanks ?? 0 ?></h3>
                        <h6><?= Yii::t('app', 'Thanks') ?></h6>
                    </div>
                </div>

            </div>


        </div>
    </div>

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
            'itemView' => $this->context->action->id . '_',
            'options' => ['class' => 'list-group'],
        ]) ?>
    </div>
    </div>
</section>
