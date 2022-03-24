<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\base\Message as ActiveModel;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\base\Message */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-3 hidden-sm hidden-xs">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Yii::t('app', 'Folder') ?></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body p-0" style="display: block;">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item active">
                        <a href="<?= Url::to(['/message/index', 'status' => 0], false, false) ?>" class="nav-link">
                            <i class="fas fa-inbox"></i> <?= Yii::t('cons', 'STATUS_UNREAD') ?><?= Yii::t('app', 'Message') ?>
                            <span class="badge bg-primary float-right"><?= $unread ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::to(['/message/index', 'status' => 1], false, false) ?>" class="nav-link">
                            <i class="far fa-envelope"></i> <?= Yii::t('cons', 'STATUS_READ') ?><?= Yii::t('app', 'Message') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::to(['/message/index', 'status' => -1], false, false) ?>" class="nav-link">
                            <i class="far fa-trash-alt"></i> <?= Yii::t('cons', 'STATUS_RECYCLE') ?>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Yii::t('app', 'Label') ?></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-danger"></i> <?= Yii::t('app', 'Important') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-warning"></i> <?= Yii::t('app', 'Warning') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-primary"></i> <?= Yii::t('app', 'Normal') ?>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= $model->name ?></h2>
            </div>

            <div class="card-body">
                <?php
                    if ($model->content && strlen($model->content) > 0) {
                        if ($model->type == ActiveModel::TYPE_JSON) {
                            $content = json_decode($model->content, true);
                            echo DetailView::widget([
                                'model' => $content,
                                'attributes' => array_keys($content),
                            ]);
                        } else {
                            echo $model->content;
                        }
                    } else {
                        echo $model->messageType->content;
                    }
                ?>
            </div>
        </div>
    </div>
</div>
