<?php
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\base\Lang;
use frontend\helpers\Url;

/* @var $this yii\web\View */
/* @var $context \frontend\controllers\BaseController */
$this->title = $context->getBlockValue('common_website_name') ?: '';

$store = $this->context->store;
$context = $this->context;

NavBar::begin([
    // 'brandLabel' => Html::img($store->settings['website_logo'] ?: $context->getImage('logo.png'), ['height' => 40]),
    'brandLabel' => $context->getBlockValue('common_website_name') ?: $store->settings['website_name'] ?: $store->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark nav-white fixed-top',
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


$menuItems = [
    ['label' => Yii::t('cms', 'Home'), 'url' => '#myCarousel', ],
    ['label' => Yii::t('cms', 'Product'), 'url' => '#product', ],
    ['label' => Yii::t('cms', 'About us'), 'url' => '#about', ],
    ['label' => Yii::t('cms', 'Contact us'), 'url' => '#contact', 'linkOptions' => ['class' => 'btn btn-theme']],
];

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

<section class="page-section bg-light text-dark pt-4">

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">
        <div class="container marketing">

            <h1 class="text-center pb-5"><?= $context->getBlockValue('home_service') ?></h1>

            <!-- Three columns of text below the carousel -->
            <div class="row text-center">
                <?php for ($i = 0; $i < 3; $i++) { ?>
                <div class="col-lg-4 wow fadeIn<?= $i == 0 ? 'Left' : ($i == 2 ? 'Right' : 'Up') ?>">
                    <div class="icon-block mb-2"><i class="fa <?= $context->getBlockFieldIndex($i, 'home_service', 'param1') ?>"></i></div>
                    <h3 class="mb-2"><?= $context->getBlockValueIndex($i, 'home_service', 'brief') ?></h3>
                    <p><?= $context->getBlockValueIndex($i, 'home_service', 'content') ?></p>
                </div><!-- /.col-lg-4 -->
                <?php } ?>
            </div><!-- /.row -->
        </div>

    </div><!-- /.container -->

</section>

<section class="page-section bg-white text-center" id="about">
    <div class="container">

        <h1 class="text-center pb-5"><?= $context->getBlockValue('home_about_us') ?></h1>

        <div class="row featurette">
            <div class="col-md-6 wow fadeInLeft mb-3">
                <h2 class="text-lg-left"><?= $context->getBlockValue('home_about_us', 'brief') ?></h2>
                <p class="lead text-lg-left"><?= nl2br($context->getBlockValue('home_about_us', 'content')) ?></p>
            </div>
            <div class="col-md-6 wow fadeInRight">
                <img src="<?= nl2br($context->getBlockValue('home_about_us', 'thumb')) ?>" class="img-fluid img-square" />
            </div>
        </div>

    </div>
</section>

<section class="page-section bg-light" id="contact">
    <div class="container">
        <h1 class="text-center pb-5"><?= $context->getBlockValue('home_contact_us') ?></h1>
        <div class="row featurette">

            <div class="col-xs-6 col-sm-6 col-md-3 contact-info text-center wow bounceIn" data-wow-duration="3s">
                <i class="fa fa-envelope-o"></i>
                <h4 class="contact_title"><?= Yii::t('cms', 'Email') ?></h4>
                <p class="contact_description"><?= $context->getBlockValueIndex(0, 'home_contact_us', 'brief') ?></p>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 contact-info text-center wow bounceIn" data-wow-duration="3s">
                <i class="fa fa-map-marker"></i>
                <h4 class="contact_title"><?= Yii::t('cms', 'Address') ?></h4>
                <p class="contact_description"><?= $context->getBlockValueIndex(1, 'home_contact_us', 'brief') ?></p>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 contact-info text-center wow bounceIn" data-wow-duration="3s">
                <i class="fa fa-phone"></i>
                <h4 class="contact_title"><?= Yii::t('cms', 'Call Us') ?></h4>
                <p class="contact_description"><?= $context->getBlockValueIndex(2, 'home_contact_us', 'brief') ?></p>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 contact-info text-center wow bounceIn" data-wow-duration="3s">
                <i class="fa fa-weixin"></i>
                <h4 class="contact_title"><?= Yii::t('cms', 'WeChat') ?></h4>
                <p class="contact_description"><?= $context->getBlockValueIndex(3, 'home_contact_us', 'brief') ?></p>
            </div>

        </div>
    </div>
</section>

<?php if (strlen($store->settings['website_map']) > 5) { ?>
<section class="page-section bg-light pt-0" id="home-map">
    <div class="container-fluid p-0" style="overflow: hidden; height: 100%">
        <?= $store->settings['website_map'] ?>
    </div>
</section>
<?php } ?>

<section class="page-section bg-dark text-light">
    <footer class="container">
        <div class="row align-items-center text-center">
            <div class="col-lg-12 mb-12">
                <?= nl2br($context->getBlockValue('common_website_footer', 'content')) ?>
            </div>
        </div>
    </footer>
</section>

<script>
    $('.nav a, #myCarousel a').click(function(){
        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top - 60
        }, 1000);
        $('#w0-collapse').removeClass('show');
        return false;
    });
    $(document).ready(function () {
        jQuery.cookieBar({
            message:'We use cookies to give you the best experience on our website. By continuing, you agree to our use of cookies.',
            fixed: true,
            policyButton: false,
            expireDays: 60,
        });
    });
</script>