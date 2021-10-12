<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Funboot';
?>
<section class="page-section" id="contact">
    <div class="container text-center">
        <h3 class="text-center pb-3">关于Funboot</h3>

        <p class="lead text-secondary text-left">
            <?= Html::a('Funboot', 'https://github.com/funson86/funboot', ['class' => '', 'target' => '_blank']) ?>
            起源于<?= Html::a('Funshop', 'https://github.com/funson86/funshop', ['class' => '', 'target' => '_blank']) ?>，
            为了支持多域名多店铺而重新改造为Saas系统，在Saas基础上再逐步扩展功能并开发一些基础的子系统如个人收款/CMS网站/商城/BBS/聊天室/微信公众号&小程序等，
            解决自由开发者开发单项目多客户&多个项目的代码重用以及多次部署的痛点，也可以作为平台创业公司首选快速开发平台并提供基础高性能优化方式。
        </p>

        <p class="mb-5">
            <?= Html::a('源码安装文档', 'https://github.com/funson86/funboot/tree/master/docs/guide-zh-CN/start-installation.md', ['class' => 'btn btn-lg btn-primary wow bounceInUp', 'target' => '_blank', 'data-wow-duration' => '3s']) ?>
            <?= Html::a('安装视频', 'https://www.bilibili.com/video/BV1kP4y1t7ky/', ['class' => 'btn btn-lg btn-info wow bounceInUp', 'target' => '_blank', 'data-wow-duration' => '3s']) ?>
        </p>

        <iframe src="//player.bilibili.com/player.html?aid=891114186&bvid=BV1kP4y1t7ky&cid=423484033&page=1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true" width="100%" height="600"> </iframe>
    </div>
</section>

<section class="page-section bg-light" id="contact">
    <div class="container">
        <h1 class="text-center pb-5">Funboot特性</h1>
        <div class="row featurette">

            <div class="col-6 col-xs-6 col-sm-6 col-md-3 contact-info text-center mb-4 wow bounceIn" data-wow-duration="3s">
                <div class="bg-white p-3">
                    <i class="fa fa-th"></i>
                    <h4 class="contact_title"><?= Yii::t('app', 'Saas系统') ?></h4>
                    <p class="contact_description">内置多个子系统，支持自定义域名，单域名代码切换店铺</p>
                </div>
            </div>

            <div class="col-6 col-xs-6 col-sm-6 col-md-3 contact-info text-center mb-4 wow bounceIn" data-wow-duration="3s">
                <div class="bg-white p-3">
                    <i class="fa fa-cubes"></i>
                    <h4 class="contact_title"><?= Yii::t('app', '子系统') ?></h4>
                    <p class="contact_description">个人收款/CMS/商城/BBS/聊天室/微信公众号&小程序等</p>
                </div>
            </div>

            <div class="col-6 col-xs-6 col-sm-6 col-md-3 contact-info text-center mb-4 wow bounceIn" data-wow-duration="3s">
                <div class="bg-white p-3">
                    <i class="fa fa-list-alt"></i>
                    <h4 class="contact_title"><?= Yii::t('app', '简洁后台') ?></h4>
                    <p class="contact_description">支持Gii，基础CRUD/导入导出，内置钩子简化后台开发代码</p>
                </div>
            </div>

            <div class="col-6 col-xs-6 col-sm-6 col-md-3 contact-info text-center mb-4 wow bounceIn" data-wow-duration="3s">
                <div class="bg-white p-3">
                    <i class="fa fa-puzzle-piece"></i>
                    <h4 class="contact_title"><?= Yii::t('app', '多种表单') ?></h4>
                    <p class="contact_description">图片上传/时间日期范围选择/颜色选择/百度Markdown编辑器/多行文本等</p>
                </div>
            </div>

            <div class="col-6 col-xs-6 col-sm-6 col-md-3 contact-info text-center mb-4 wow bounceIn" data-wow-duration="3s">
                <div class="bg-white p-3">
                    <i class="fa fa-user-secret"></i>
                    <h4 class="contact_title"><?= Yii::t('app', '权限控制') ?></h4>
                    <p class="contact_description">基于RBAC四级权限控制，自由分配用户多角色权限控制</p>
                </div>
            </div>

            <div class="col-6 col-xs-6 col-sm-6 col-md-3 contact-info text-center mb-4 wow bounceIn" data-wow-duration="3s">
                <div class="bg-white p-3">
                    <i class="fa fa-tags"></i>
                    <h4 class="contact_title"><?= Yii::t('app', 'API接口') ?></h4>
                    <p class="contact_description">在Yii2 RESTful基础上完善接口，提供OAUTH2等</p>
                </div>
            </div>

            <div class="col-6 col-xs-6 col-sm-6 col-md-3 contact-info text-center mb-4 wow bounceIn" data-wow-duration="3s">
                <div class="bg-white p-3">
                    <i class="fa fa-book"></i>
                    <h4 class="contact_title"><?= Yii::t('app', '开发文档') ?></h4>
                    <p class="contact_description">丰富的开发文档，前后端子系统开发样例供开发时参考拷贝</p>
                </div>
            </div>

            <div class="col-6 col-xs-6 col-sm-6 col-md-3 contact-info text-center mb-4 wow bounceIn" data-wow-duration="3s">
                <div class="bg-white p-3">
                    <i class="fa fa-users"></i>
                    <h4 class="contact_title"><?= Yii::t('app', '高性能') ?></h4>
                    <p class="contact_description">内置缓存，支持Redis Mongodb Redis Elasticsearch SnowFlake等</p>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="page-section bg-dark text-white" id="star">
    <div class="container text-center">
        <!--h1 class="text-center">STAR支持</h1-->

        <p class="lead mb-5">欢迎各位大牛改进Funboot代码，点击Star支持我们持续改进</p>

        <p><?= Html::a('去Star支持一下作者', 'https://github.com/funson86/funboot/', ['class' => 'btn btn-lg btn-success wow tada', 'target' => '_blank']) ?></p>
    </div>
</section>

<section class="page-section bg-white">
    <div class="container-fluid">
        <h1 class="text-center pb-5"><?= Yii::t('app', '视频 & 快照') ?></h1>

        <div class="row featurette text-center">
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><iframe src="//player.bilibili.com/player.html?aid=591040230&bvid=BV1vq4y1d7WU&cid=423573264&page=1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true" width="100%" height="300"> </iframe> <?= Html::a('大屏观看', 'https://www.bilibili.com/video/BV1vq4y1d7WU', ['class' => '', 'target' => '_blank']) ?></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><iframe src="//player.bilibili.com/player.html?aid=891041225&bvid=BV18P4y1t7ub&cid=423573859&page=1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true" width="100%" height="300"> </iframe> <?= Html::a('大屏观看', 'https://www.bilibili.com/video/BV18P4y1t7ub', ['class' => '', 'target' => '_blank']) ?></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><iframe src="//player.bilibili.com/player.html?aid=891069626&bvid=BV1BP4y1t7q2&cid=423574298&page=1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true" width="100%" height="300"> </iframe> <?= Html::a('大屏观看', 'https://www.bilibili.com/video/BV1BP4y1t7q2', ['class' => '', 'target' => '_blank']) ?></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><iframe src="//player.bilibili.com/player.html?aid=806050205&bvid=BV1j34y1S7Bn&cid=423576156&page=1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true" width="100%" height="300"> </iframe> <?= Html::a('大屏观看', 'https://www.bilibili.com/video/BV1j34y1S7Bn', ['class' => '', 'target' => '_blank']) ?></div>
        </div>


        <div class="row featurette">
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><a data-fancybox="gallery" href="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png"><img class="img-fluid lazyload" data-src="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png" src="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png" /></a></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><a data-fancybox="gallery" href="https://i.loli.net/2021/09/27/gxWGJzbOXLK7y4V.png"><img class="img-fluid lazyload" data-src="https://i.loli.net/2021/09/27/gxWGJzbOXLK7y4V.png" src="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png" /></a></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><a data-fancybox="gallery" href="https://i.loli.net/2021/09/27/5YJzOGb9vHQEreh.png"><img class="img-fluid lazyload" data-src="https://i.loli.net/2021/09/27/5YJzOGb9vHQEreh.png" src="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png" /></a></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><a data-fancybox="gallery" href="https://i.loli.net/2021/09/27/OPW1XlALSK3tVNe.png"><img class="img-fluid lazyload" data-src="https://i.loli.net/2021/09/27/OPW1XlALSK3tVNe.png" src="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png" /></a></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><a data-fancybox="gallery" href="https://i.loli.net/2021/09/27/gSUQn5rt4zCNZIE.png"><img class="img-fluid lazyload" data-src="https://i.loli.net/2021/09/27/gSUQn5rt4zCNZIE.png" src="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png" /></a></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><a data-fancybox="gallery" href="https://i.loli.net/2021/09/27/AndQEaqCb3PsKFp.png"><img class="img-fluid lazyload" data-src="https://i.loli.net/2021/09/27/AndQEaqCb3PsKFp.png" src="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png" /></a></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><a data-fancybox="gallery" href="https://i.loli.net/2021/09/27/UXwekmHFM8ATsnW.png"><img class="img-fluid lazyload" data-src="https://i.loli.net/2021/09/27/UXwekmHFM8ATsnW.png" src="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png" /></a></div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 wow pulse"><a data-fancybox="gallery" href="https://i.loli.net/2021/09/27/1gEOw6idfTL9e87.png"><img class="img-fluid lazyload" data-src="https://i.loli.net/2021/09/27/1gEOw6idfTL9e87.png" src="https://i.loli.net/2021/09/27/65SqdB71gAuWtPU.png" /></a></div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        try {
            lazyload();
            if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))) {
                new WOW().init();
            }
            ;
        } catch (e) {
            console.log(e)
        }
    });
</script>