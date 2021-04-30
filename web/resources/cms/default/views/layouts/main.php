<?php
use yii\helpers\Html;
use frontend\components\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\models\cms\Catalog;

/* @var $this \yii\web\View */
/* @var $content string */

$store = $this->context->store;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($store->settings['website_seo_title'] ?: $store->settings['website_name']) ?></title>
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web/resources/plugins/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web/resources/css/cms_base.css') ?>" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web/resources/cms/' . $this->context->theme . '/css/style.css') ?>" rel="stylesheet">
    <link rel="icon" href="<?= $this->context->getFavicon() ?>" type="image/x-icon" />
    <script src="<?= Yii::getAlias('@web/resources/js/jquery.min.js') ?>"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<section id="topbar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="pull-left hidden-xs"><i class="fa fa-clock-o"></i><span>欢迎访问<?= $store->settings['website_name'] ?></span></p>
                <p class="pull-right"><i class="fa fa-phone"></i><?= $store->settings['website_name'] ?></p>
            </div>
        </div>
    </div>
</section>

<header id="header">
    <div class="navbar navbar-default navbar-static-top margin-0 navbar-main">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->urlManager->createUrl(['/']) ?>"><img src="<?= $this->context->getLogo() ?>" height="42" alt="logo"/></a>
            </div>
            <div class="navbar-collapse collapse ">
                <ul class="nav navbar-nav">
                    <?php foreach ($this->context->mainMenu2 as $item) { ?>
                        <?php if (isset($item['items'])) { ?>
                            <li class="dropdown <?php if ($item['active']) { echo 'active'; } ?>">
                                <a href="<?= $item['url'] ?>" data-toggle="dropdown" class="dropdown-toggle"><?= fbt(Catalog::getTableCode(), $item['id'], 'name', Yii::$app->language) ?: $item['name'] ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($item['items'] as $v) { ?>
                                        <li><a href="<?= $v['url'] ?>"><?= $v['name'] ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li class="<?php if ($item['active']) { echo 'active'; } ?>"><a href="<?= $item['url'] ?>"><?= fbt(Catalog::getTableCode(), $item['id'], 'name', Yii::$app->language) ?: $item['name'] ?></a></li>
                        <?php } ?>
                    <?php } ?>
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-globe"></i></a>
                        <div id="w5" class="dropdown-menu">
                            <a class="funboot-lang dropdown-item" href="javascript:;" data-lang="zh-CN"><i class="flag-icon flag-icon-cn mr-2"></i>中文</a>
                            <a class="funboot-lang dropdown-item" href="javascript:;" data-lang="en"><i class="flag-icon flag-icon-gb mr-2"></i>English</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<?= \common\widgets\cms\Banner::widget(['banner' => $this->context->banner]) ?>

<?= $content ?>

<footer id="footer">
    <div class="container">
        <div class="row margin-0 footer-menu">
            <?php foreach ($this->context->mainMenu2 as $item) { ?>
                <div class="col-lg-2 col-xs-6">
                    <a href="<?= $item['url'] ?>"><?= $item['name'] ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            <?php } ?>
        </div>

        <div class="row margin-0 footer-copyright">
            <div class="col-md-12 col-xs-12">
                <p>&copy; <?= date('Y') ?> <?= $store->settings['website_copyright'] ?></p>
            </div>
        </div>
    </div>
</footer>

<button id="bind" type="button" class="btn btn-scroll-top">
    <a href="#top"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
</button>

<script src="<?= Yii::getAlias('@web/resources/js/bootstrap.min.js') ?>"></script>
<script src="<?= Yii::getAlias('@web/resources/js/cms_base.js') ?>"></script>
<script src="<?= Yii::getAlias('@web/resources/cms/' . $this->context->theme . '/js/main.js') ?>"></script>

<?php
$urlSetLanguage = Url::to(['/site/set-language'], false, false);
$js = <<<JS
$('.funboot-lang').click(function() {
    let lang = $(this).data('lang')
    let param = {
        lang: lang
    }
    $.get("{$urlSetLanguage}", param, function(data) {
        if (parseInt(data.code) === 200) {
            window.location.reload();
        }
    })
});
JS;

$this->registerJs($js);
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



