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
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <?php if ($exception instanceof NotFoundHttpException) { ?>
        <h2 class="pb-3"><?= Html::a(Yii::t('app', 'Go Home'), Url::to(['/']), ['class' => 'btn btn-success btn-block']) ?></h2>
    <?php } ?>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>
