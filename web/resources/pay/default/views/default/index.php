<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\pay\Payment as ActiveModel;
use frontend\assets\PayLandingAsset;
use frontend\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\pay\Payment */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'FunPay';

$store = $this->context->store;
$context = $this->context;

?>

<style>
    @media (max-width: 992px) {
        .hidden-sm {
            display: none;
        }
    }
</style>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-6 my-auto">
                <div class="header-content mx-auto">
                    <h1 class="mb-5">FunPay 个人收款支付系统<span class="">V1.1</span></h1>
                    <a href="<?= Url::to(['/pay/default/pay']) ?>" class="btn btn-outline btn-xl js-scroll-trigger">立即体验</a> &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="https://github.com/funson86/funpay" class="btn btn-outline btn-xl js-scroll-trigger orange">开发教程</a>
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
                                <img src="<?= $context->getImage('demo-screen-0.jpg') ?>" class="img-fluid" alt="">
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
                                <img src="<?= $context->getImage('demo-screen-1.jpg') ?>" class="img-fluid" alt="">
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
                                <i class="fa fa-lock text-primary"></i>
                                <h3>安全</h3>
                                <p class="text-muted">无需任何外挂监听，无封号冻结风险，资金流量不经过任何第三方直达个人账号</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="feature-item">
                                <i class="fa fa-gift text-primary"></i>
                                <h3>免费</h3>
                                <p class="text-muted">每笔交易直接全额到达你的个人账户，无任何中间手续费、通道费等各种名目费用</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="feature-item">
                                <i class="fa fa-book text-primary"></i>
                                <h3>易用</h3>
                                <p class="text-muted">无需签约，一张收款二维码搞定收款，支持微信、支付宝、QQ、云闪付等，无需集成任何支付SDK代码</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="feature-item">
                                <i class="fa fa-github text-primary"></i>
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
                    <a class="badge-link" href="https://github.com/funson86/funpay/"><img src="/resources/pay/images/github.png" alt=""></a>
                    <a class="badge-link" href="https://gitee.com/funson86/funpay/"><img src="/resources/pay/images/gitee.png" alt=""></a>
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
