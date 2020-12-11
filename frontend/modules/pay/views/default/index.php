<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\pay\Payment as ActiveModel;
use frontend\assets\PayLandingAsset;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Address */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'FunPay';

$store = $this->context->store;

$this->registerCssFile('/resources/pay/css/funpay.css', ['depends' => \frontend\assets\PayLandingAsset::className()]);
$this->registerJsFile('/resources/pay/js/funpay.js', ['depends' => \frontend\assets\PayLandingAsset::className()]);

?>

<style>
    @media (max-width: 992px) {
        .hidden-sm {
            display: none;
        }
    }
</style>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a href="<?= Yii::$app->urlManager->createUrl(['/']) ?>" class="navbar-brand">
            <img src="<?= $store->settings['website_logo'] ?: Yii::$app->params['defaultWebsiteLogo'] ?>" alt="Funpay" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">FunPay</span>
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/']) ?>" class="nav-link"><?= Yii::t('app', 'Home') ?></a>
                </li>
                <li class="nav-item">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/pay/default/pay']) ?>" class="nav-link"><?= Yii::t('app', '支付体验') ?></a>
                </li>
                <li class="nav-item">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/pay/default/list']) ?>" class="nav-link"><?= Yii::t('app', '捐赠名单') ?></a>
                </li>
                <li class="nav-item">
                    <a href="https://github.com/funson86/funboot/" target="_blank" class="nav-link"><?= Yii::t('app', 'Funboot开发平台') ?></a>
                </li>
            </ul>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto hidden-sm">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item">
                <a class="nav-link" href="https://github.com/funson86/funboot/" target="_blank"><i class="fab fa-github"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://github.com/funson86" target="_blank"><i class="fas fa-user-alt"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fab fa-qq"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media text-center" style="text-align: center; align-items: center">
                            <img src="/resources/images/funboot-qq-qun.png">
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="https://jq.qq.com/?_wv=1027&k=OZ8X3qjK" target="_blank" class="dropdown-item dropdown-footer">QQ 群：798843502</a>
                </div>
            </li>
        </ul>

    </div>
</nav>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-6 my-auto">
                <div class="header-content mx-auto">
                    <h1 class="mb-5">FunPay 个人收款支付系统<span class="">V1.1</span></h1>
                    <a href="#download" class="btn btn-outline btn-xl js-scroll-trigger">立即体验</a> &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#download" class="btn btn-outline btn-xl js-scroll-trigger orange">开发教程</a>
                </div>
            </div>
            <div class="col-lg-6 my-auto">
                <div class="device-container text-center">
                    <div class="attr_rio">易部署</div>
                    <div class="attr_sun2">开源代码</div>
                    <div class="attr_sun">完全免费</div>
                    <div class="attr_lon">无需签约</div>
                    <div class="device-mockup iphone6_plus portrait white">
                        <div class="device">
                            <div class="screen">
                                <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                <img src="/resources/pay/img/demo-screen-1.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="button">
                                <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="features" id="features">
    <div class="container">
        <div class="section-heading text-center">
            <h2>全开源安全收款解决方案</h2>
            <p class="text-muted">完美解决个人在线收款支付接口难题</p>
            <hr>
        </div>
        <div class="row">
            <div class="col-lg-4 my-auto">
                <div class="device-container">
                    <div class="device-mockup iphone6_plus portrait white">
                        <div class="device">
                            <div class="screen">
                                <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                <img src="/resources/pay/img/demo-screen-1.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="button">
                                <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 my-auto">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="feature-item">
                                <i class="fas fa-lock text-primary"></i>
                                <h3>安全</h3>
                                <p class="text-muted">无需任何外挂监听，无封号冻结风险，资金流量不经过任何第三方直达个人账号</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="feature-item">
                                <i class="fas fa-gift text-primary"></i>
                                <h3>免费</h3>
                                <p class="text-muted">每笔交易直接全额到达你的个人账户，无任何中间手续费、通道费等各种名目费用</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="feature-item">
                                <i class="fas fa-book-open text-primary"></i>
                                <h3>易用</h3>
                                <p class="text-muted">无需签约，一张收款二维码搞定收款，支持微信、支付宝、QQ、云闪付等，无需集成任何支付SDK代码</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="feature-item">
                                <i class="fab fa-github text-primary"></i>
                                <h3>开源</h3>
                                <p class="text-muted">所有代码代码开源免费，基于Funboot开发平台，遵循MIT协议!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="download bg-primary text-center" id="download">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2 class="section-heading">如何开发使用FunPay</h2>
                <p>FunPay是开源免费的个人收款支付系统。系统源代码在github和gitee上均做了开源，有详细的教程和源码供参考，详情请点击下方链接。</p>
                <div class="badges">
                    <a class="badge-link" href="https://github.com/funson86/funpay/"><img src="/resources/pay/img/github.png" alt=""></a>
                    <a class="badge-link" href="https://gitee.com/funson86/funpay/"><img src="/resources/pay/img/gitee.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="reviews" id="reviews">
    <div class="container">
        <div class="section-heading text-center">
            <h2>用户体验评价</h2>
            <p class="text-muted">Reviews</p>
            <hr>
        </div>
        <div class="row">
                <div class="col-md-6">
                    <div class="reviews_item pt-5">
                        <div class="reviews_item_icon pull-left">“</div>
                        <h3>以后收到捐赠不用再一条条添加到捐赠列表了，感谢！</h3>
                        <h5>Jone</h5>
                        <div class="reviews_item_icon1 pull-right text-right">“</div>
                    </div>
                </div><!-- End off col-md-6 -->

                <div class="col-md-6">
                    <div class="reviews_item pt-5">
                        <div class="reviews_item_icon pull-left">“</div>
                        <h3>虽然无法大规模商用，用在个人收款场景上妥妥的简单好使。</h3>
                        <h5>Butterfly</h5>
                        <div class="reviews_item_icon1 pull-right text-right">“</div>
                    </div>
                </div><!-- End off col-md-6 -->
                <div class="col-md-6">
                    <div class="reviews_item pt-5">
                        <div class="reviews_item_icon pull-left">“</div>
                        <h3>作为自由职业者正愁某宝买不到营业执照，也找不到长期靠谱的第三方通道，轻松部署轻松收款。</h3>
                        <h5>Funson</h5>
                        <div class="reviews_item_icon1 pull-right text-right">“</div>
                    </div>
                </div><!-- End off col-md-6 -->
                <div class="col-md-6">
                    <div class="reviews_item pt-5">
                        <div class="reviews_item_icon pull-left">“</div>
                        <h3>灰色产业申请不到支付接口，这个方案简单不错，帮上大忙了。</h3>
                        <h5>James</h5>
                        <div class="reviews_item_icon1 pull-right text-right">“</div>
                    </div>
                </div><!-- End off col-md-6 -->

        </div>
    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; FunPay <?= date('Y') ?>. All Rights Reserved.</p>
    </div>
</footer>
