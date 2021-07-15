<?php
use frontend\assets\PayLandingAsset;

/* @var $this \yii\web\View */
/* @var $content string */

PayLandingAsset::register($this);

$store = $this->context->store;

$this->title = strlen($store->settings['website_seo_title']) > 5 ? $store->settings['website_seo_title'] : $store->name;

?>

<?php $this->beginPage() ?>
<html lang="en">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?= $this->title ?></title>
    <?php $this->head() ?>
</head>

<body id="page-top">
<?php $this->beginBody() ?>

<?= $content ?>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
