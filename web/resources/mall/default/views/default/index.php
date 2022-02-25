<?php
use common\helpers\ImageHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\mall\Product;

/* @var $this yii\web\View */
/* @var $productsNew \common\models\mall\Product[] */
/* @var $productsHot \common\models\mall\Product[] */


$this->title = '';

$store = $this->context->store;

?>

<section class="page-section pt-0 pb-7 banner">
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="https://preview.colorlib.com/theme/divisima/img/bg.jpg.webp">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 text-white">
                        <span><?= Yii::t('mall', 'New Arrivals') ?></span>
                        <h2><?= Yii::t('mall', 'Erke jackets') ?></h2>
                        <p><?= Yii::t('mall', 'Erke jackets is very suitable for young women and men.') ?></p>
                        <a href="#" class="site-btn sb-line"><?= Yii::t('mall', 'Discover') ?></a>
                        <a href="#" class="site-btn sb-white"><?= Yii::t('mall', 'Shop Now') ?></a>
                    </div>
                </div>
                <div class="offer-card text-white">
                    <span><?= Yii::t('mall', 'from') ?></span>
                    <h2><?= $this->context->getNumberByCurrency(29, 0) ?></h2>
                    <p><?= Yii::t('mall', 'Shop Now') ?></p>
                </div>
            </div>
        </div>
        <div class="hs-item set-bg" data-setbg="https://preview.colorlib.com/theme/divisima/img/bg-2.jpg.webp">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 text-white">
                        <span><?= Yii::t('mall', 'New Arrivals') ?></span>
                        <h2><?= Yii::t('mall', 'Erke jackets') ?></h2>
                        <p><?= Yii::t('mall', 'Erke jackets is very suitable for young women and men.') ?></p>
                        <a href="#" class="site-btn sb-line"><?= Yii::t('mall', 'Discover') ?></a>
                        <a href="#" class="site-btn sb-white"><?= Yii::t('mall', 'Shop Now') ?></a>
                    </div>
                </div>
                <div class="offer-card text-white">
                    <span><?= Yii::t('mall', 'from') ?></span>
                    <h2><?= $this->context->getNumberByCurrency(29, 0) ?></h2>
                    <p><?= Yii::t('mall', 'Shop Now') ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="slide-num-holder" id="snh-1"></div>
    </div>
</section>

<section class="page-section py-3 product">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h3><?= Yii::t('mall', 'Hot Deals') ?></h3>
                </div>
            </div>
        </div>
        <div class="row property-gallery">
            <?php foreach ($productsHot as $product) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="product-item-pic set-bg" data-setbg="<?= $this->context->getImage($product->thumb) ?>">
                            <div class="label new"><?= Yii::t('mall', 'New') ?></div>
                            <ul class="product-hover">
                                <li><a href="<?= $this->context->getImage($product->image) ?>" data-fancybox="gallery"><i class="fa fa-expand"></i></a></li>
                                <li><a href="<?= $this->context->getSeoUrl($product) ?>"><i class="fa fa-shopping-bag"></i></a></li>
                            </ul>
                        </div>
                        <div class="product-item-text">
                            <h6><?= Html::a(fbt(Product::getTableCode(), $product->id, 'name', $product->name), $this->context->getSeoUrl($product)) ?></h6>
                            <div class="rating">
                                <?= \common\helpers\UiHelper::renderStar($product->star) ?>
                            </div>
                            <div class="product-price"><?= $this->context->getNumberByCurrency($product->price) ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<section class="page-section py-3 product">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h3><?= Yii::t('mall', 'New Arrivals') ?></h3>
                </div>
            </div>
        </div>
        <div class="row property-gallery">
            <?php foreach ($productsNew as $product) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="product-item-pic set-bg" data-setbg="<?= $this->context->getImage($product->thumb) ?>">
                            <div class="label new"><?= Yii::t('mall', 'New') ?></div>
                            <ul class="product-hover">
                                <li><a href="<?= $this->context->getImage($product->image) ?>" data-fancybox="gallery"><i class="fa fa-expand"></i></a></li>
                                <li><a href="<?= $this->context->getSeoUrl($product) ?>"><i class="fa fa-shopping-bag"></i></a></li>
                            </ul>
                        </div>
                        <div class="product-item-text">
                            <h6><?= Html::a(fbt(Product::getTableCode(), $product->id, 'name', $product->name), $this->context->getSeoUrl($product)) ?></h6>
                            <div class="rating">
                                <?= \common\helpers\UiHelper::renderStar($product->star) ?>
                            </div>
                            <div class="product-price"><?= $this->context->getNumberByCurrency($product->price) ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<section class="page-section py-5 services">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services-item">
                    <i class="fa fa-car"></i>
                    <h6><?= Yii::t('mall', 'Free Shipping') ?></h6>
                    <p><?= Yii::t('mall', 'For all oder over $99') ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services-item">
                    <i class="fa fa-money"></i>
                    <h6><?= Yii::t('mall', 'Money Back Guarantee') ?></h6>
                    <p><?= Yii::t('mall', 'If good have Problems') ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services-item">
                    <i class="fa fa-support"></i>
                    <h6><?= Yii::t('mall', 'Online Support 24/7') ?></h6>
                    <p><?= Yii::t('mall', 'Dedicated support') ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services-item">
                    <i class="fa fa-headphones"></i>
                    <h6><?= Yii::t('mall', 'Payment Secure') ?></h6>
                    <p><?= Yii::t('mall', '100% secure payment') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
    var hero_s = $(".hero-slider");
    hero_s.owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        dots: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="fa fa-chevron-circle-left"></i>', '<i class="fa fa-chevron-circle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        onInitialized: function() {
            var a = this.items().length;
            $("#snh-1").html("<span>1</span><span>" + a + "</span>");
        }
    }).on("changed.owl.carousel", function(a) {
        var b = --a.item.index, a = a.item.count;
        $("#snh-1").html("<span> "+ (1 > b ? b + a : b > a ? b - a : b) + "</span><span>" + a + "</span>");

    });

    hero_s.append('<div class="slider-nav-warp"><div class="slider-nav"></div></div>');
    $(".hero-slider .owl-nav, .hero-slider .owl-dots").appendTo('.slider-nav');
});
</script>
