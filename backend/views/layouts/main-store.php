<?php

/* @var $this yii\web\View */

use common\widgets\adminlte\AdminlteAsset;
use yii\helpers\Html;
use backend\assets\AppAsset;

$this->title = $this->context->store->name;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini text-sm">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render('../site/header', ['type' => 'store']) ?>

        <?= $this->render('../site/left', ['type' => 'store'])?>

        <?= $this->render('content-store', [
            'content' => $content
        ]) ?>

        <?= $this->render('footer') ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>

