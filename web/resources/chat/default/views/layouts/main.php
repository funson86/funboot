<?php
use yii\helpers\Html;
use common\widgets\Alert;
use frontend\assets\ChatAsset;

/* @var $this \yii\web\View */
/* @var $content string */


$store = $this->context->store;
ChatAsset::register($this);

$this->registerCssFile($this->context->getCss('style.css?v=' . Yii::$app->params['system_version']), ['depends' => ChatAsset::className()]);
$this->registerJsFile($this->context->getJs('main.js'), ['depends' => ChatAsset::className()]);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= $this->title ? (Html::encode($this->title) . ' - ' . ($store->settings['website_name'] ?: $store->name)) : ($store->settings['website_name'] ?: $store->name) ?></title>
    <meta name="keywords" content="<?= Html::encode($store->settings['website_seo_keywords'] ?: $store->settings['website_name']) ?>"/>
    <meta name="description" content="<?= Html::encode($store->settings['website_seo_description'] ?: $store->settings['website_name']) ?>"/>
    <link rel="icon" href="<?= $this->context->getFavicon() ?>" type="image/x-icon" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <?= $this->render('nav') ?>

    <main class="container">
        <?= Alert::widget() ?>
    </main>

    <main class="container">
        <?= $content ?>
    </main>

    <?= $this->render('footer') ?>
    <?= \common\widgets\alert\SweetAlert2::widget() ?>

    <!-- Scroll to Top -->
    <button type="button" class="btn btn-scroll-top" id="goTop" title="<?= Yii::t('app', 'Go Top') ?>"><span class="fa fa-chevron-up"></span></button>

    <?= strlen($store->settings['website_stat']) > 10 ? $store->settings['website_stat'] : '' ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
