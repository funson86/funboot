<?php

use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error text-center mt-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p class="mb-5">
        <?= Yii::t('app', 'Please contact us if you think this is a server error. Thank you.') ?>
    </p>


    <h2 class="pb-3"><?= Html::a(Yii::t('app', 'Go Home'), Url::to(['/']), ['class' => 'btn btn-success btn-block']) ?></h2>

</div>
