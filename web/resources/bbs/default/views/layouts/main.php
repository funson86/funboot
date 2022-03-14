<?php
use yii\helpers\Html;
use frontend\assets\BbsAsset;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

BbsAsset::register($this);
$this->registerCssFile($this->context->getCss('style.css?v=' . Yii::$app->params['system_version']), ['depends' => BbsAsset::className()]);
$this->registerJsFile($this->context->getJs('main.js'), ['depends' => BbsAsset::className()]);

$store = $this->context->store;
$suffix = $store->settings['website_seo_keywords'] ?: $store->settings['website_name'] ?: $store->name;
$title = (($this->title && $suffix) ? ($this->title . ' - ' . $suffix) : ($this->title ?: $suffix));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($title) ?></title>
    <meta name="keywords" content="<?= $suffix ?>"/>
    <meta name="description" content="<?= Html::encode($store->settings['website_seo_description'] ?: $store->settings['website_name']) ?>"/>
    <link rel="icon" href="<?= $this->context->getFavicon() ?>" type="image/x-icon" />
    <?php $this->head() ?>
</head>
<body class="bg-light">
<?php $this->beginBody() ?>
    <header>
        <?= $this->render('nav') ?>
    </header>

    <main class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </main>

    <footer>
        <?= $this->render('footer') ?>
    </footer>

    <?= strlen($store->settings['website_stat']) > 10 ? $store->settings['website_stat'] : '' ?>
<?php $this->endBody() ?>

<script>
    $(document).ready(function () {
        ua = navigator.userAgent.toLowerCase();
        var regexp=/\.(bot.htm|spider.htm)(\.[a-z0-9\-]+){1,2}\//ig;
        if(!regexp.test(ua)) {
            jQuery.cookieBar({
                message:'We use cookies to give you the best experience on our website. By continuing, you agree to our use of cookies.',
                fixed: true,
                policyButton: false,
                expireDays: 60,
            });
        }
    });
</script>
</body>
</html>
<?php $this->endPage() ?>

