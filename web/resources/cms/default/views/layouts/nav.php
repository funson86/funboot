<?php
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Nav;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\base\Lang;
use frontend\helpers\Url;

$context = $this->context;
$store = $this->context->store;

NavBar::begin([
//     'brandLabel' => Html::img('/images/logo.png'),
    'brandLabel' => $this->context->store->settings['website_name'] ?: $this->context->store->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark fixed-top',
    ],
]);

// 语言
$languages = [];
foreach (Lang::getLanguageCode() as $id => $code) {
    if (($store->lang_frontend & $id) == $id) {
        $languages[] = ['label' => '<i class="flag-icon flag-icon-' . Lang::getLanguageFlag($id) . ' mr-2"></i>' . Lang::getLanguageLabels($id), 'url' => Url::attachLang($code)];
    }
}
$menuItems[] = [
    'label' => Html::tag('i', '', ['class' => 'flag-icon flag-icon-' . Lang::getLanguageFlag(Lang::getLanguageCode(Yii::$app->language, true, true))]) . ' ' . Lang::getLanguageCodeLabels(Yii::$app->language),
    'items' => $languages,
];

echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'navbar-nav'],
    'items' => $menuItems,
    'activateParents' => true,
]);

$menuItems = $this->context->mainMenu2;

$menuItems[] = ['label' => Yii::t('cms', 'Contact Us'), 'url' => Url::to(['/cms/default/contact', ]),];

echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => $menuItems,
    'activateParents' => true,
]);
NavBar::end();

?>
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



<main role="main" class="main">
    <div id="myCarousel" class="carousel slide text-light" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            for ($i = 0; $i < 5; $i++) {
                $index = $i + 1;
                if ($context->getBlockValue('home_banner_' . $index, 'brief')) {
                    ?>
                    <li data-target="#myCarousel" data-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></li>
                <?php } } ?>
        </ol>
        <div class="carousel-inner">

            <?php
            for ($i = 0; $i < 5; $i++) {
                $index = $i + 1;
                if ($context->getBlockValue('home_banner_' . $index, 'brief')) {
                    ?>
                    <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(<?= $context->getBlockValue('home_banner_' . $index, 'thumb') ?>) center top;">
                        <div class="container">
                            <div class="carousel-caption">
                                <h3><?= $context->getBlockValue('home_banner_' . $index, 'brief') ?></h3>
                                <p><?= $context->getBlockValue('home_banner_' . $index, 'content') ?></p>
                                <p><a class="btn btn-lg btn-theme animated bounceInUp" href="#contact"><?= Yii::t('cms', 'FIND OUT MORE') ?></a></p>
                            </div>
                        </div>
                    </div>
                <?php } } ?>

        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</main>
