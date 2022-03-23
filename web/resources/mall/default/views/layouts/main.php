<?php
use yii\helpers\Html;
use frontend\assets\MallAsset;
use common\helpers\CommonHelper;

/* @var $this \yii\web\View */
/* @var $content string */

MallAsset::register($this);
$this->registerCssFile($this->context->getCss('style.css?v=' . Yii::$app->params['system_version']), ['depends' => MallAsset::className()]);
$this->registerJsFile($this->context->getJs('main.js'), ['depends' => MallAsset::className()]);

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
<body>

<?php $this->beginBody() ?>

    <?= $this->render('nav') ?>

    <?= $content ?>

    <?= $this->render('footer') ?>
    <?= !Yii::$app->request->isAjax ? \common\widgets\alert\SweetAlert2::widget() : '' ?>

    <!-- Scroll to Top -->
    <button type="button" class="btn btn-scroll-top" id="goTop" title="<?= Yii::t('app', 'Go Top') ?>"><span class="fa fa-chevron-up"></span></button>

    <?= strlen($store->settings['website_stat']) > 10 ? $store->settings['website_stat'] : '' ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
