<?php
use yii\helpers\Html;
use frontend\components\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\MallAsset;

/* @var $this \yii\web\View */
/* @var $content string */

MallAsset::register($this);

$store = $this->context->store;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link href="<?= $this->context->prefixStatic ?>/css/global.css" rel="stylesheet">
    <title><?= Html::encode($this->title) ?> - <?= Html::encode($store->settings['website_seo_title']) ?></title>
    <?php $this->head() ?>
</head>
<body>

<div class="container" id="page">
    <?php $this->beginBody() ?>
    <div id="header" class="new_header">
        <?= $this->render('headerBar') ?>
        <?= $this->render('headerSearch') ?>
        <?= $this->render('headerNav') ?>
    </div>

    <?= $content ?>

    <?= $this->render('footer') ?>

    <?php $this->endBody() ?>
</div>
</body>
</html>
<?php $this->endPage() ?>

