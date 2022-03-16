<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$url = Yii::$app->request->getUrl();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php
NavBar::begin([
    'brandLabel' => $this->context->store->settings['website_name'] ?: $this->context->store->name ?: Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark nav-white fixed-top',
    ],
]);
$menuItems = [
    ['label' => Yii::t('app', 'Home'), 'url' => ['/']],
    ['label' => Yii::t('app', 'Funmall'), 'url' => 'https://funmall.funboot.net/', 'linkOptions' => ['target' => '_blank']],
    ['label' => Yii::t('app', 'Funpay'), 'url' => 'https://funpay.funboot.net/', 'linkOptions' => ['target' => '_blank']],
    ['label' => Yii::t('app', 'Funcms'), 'url' => 'https://funpay.funboot.net/', 'linkOptions' => ['target' => '_blank']],
    ['label' => Yii::t('app', 'Chat Room'), 'url' => 'https://chat.funboot.net/', 'linkOptions' => ['target' => '_blank']],
    ['label' => Yii::t('app', 'Feedback'), 'url' => ['/site/feedback']],
    ['label' => Yii::t('app', 'Funboot Demo(test/123456)'), 'url' => 'https://www.funboot.net/backend/'],
];
/*if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}*/
echo Nav::widget([
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => $menuItems,
]);
NavBar::end();
?>

<header class="masthead" style="height: <?= $url == '/' ? 50 : 20 ?>vh; min-height: <?= $url == '/' ? 50 : 20 ?>vh">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-12 text-center my-auto">
                <h3 class="">基于Yii2 Advanced模板的Saas快速开发平台</h3>
                <?php if ($url == '/') { ?>
                    <p class="pt-3">
                        <?= Html::a('系统源码', 'https://github.com/funson86/funboot', ['class' => 'btn btn-success wow bounceInLeft', 'target' => '_blank', 'data-wow-duration' => '2s']) ?>
                        <?= Html::a('开发文档', 'https://github.com/funson86/funboot/tree/master/docs/guide-zh-CN/README.md', ['class' => 'btn btn-info ml-3 wow bounceInUp', 'target' => '_blank', 'data-wow-duration' => '3s']) ?>
                        <?= Html::a('商城演示', 'https://funmall.funboot.net', ['class' => 'btn btn-danger ml-3 wow bounceInRight', 'target' => '_blank', 'data-wow-duration' => '2s']) ?>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<script>
    function _scroll(){
        var scrollTop = $(window).scrollTop();
        if (scrollTop < 10){
            $('.navbar').removeClass('bg-dark');
            $('.navbar').css('opacity', 1);
        } else {
            $('.navbar').addClass('bg-dark');
            $('.navbar').css('opacity', 0.95);
        }
    }
    $(window).on('scroll',function() {
        _scroll()
    });

    // 解决手机点击下拉部分透明，下拉后有背景
    $('.navbar-toggler').click(function () {
        if ($('#navbarCollapse').hasClass('show')) {
            $('.navbar').removeClass('bg-dark');
            $('.navbar').css('opacity', 1);
        } else {
            $('.navbar').addClass('bg-dark');
            $('.navbar').css('opacity', 0.95);
        }
    })

</script>


<?= $content ?>
<?= \common\widgets\alert\SweetAlert2::widget() ?>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::t('yii', 'Powered by {funboot}', ['funboot' => '<a href="http://github.com/funson86/funboot" rel="external">' . Yii::t('yii','Funboot') . '</a>',]) ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
