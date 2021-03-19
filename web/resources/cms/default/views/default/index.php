<?php

/* @var $this yii\web\View */
$this->title = $store->settings['website_seo_title'] . ' - ' . $store->settings['website_name'] ?: $store->name;
$this->registerMetaTag(["name" => "keywords","content" => $store->settings['website_seo_title']]);
$this->registerMetaTag(["name" => "description","content" => $store->settings['cms_seo_description']]);

?>

<section id="content">
    <div class="index-product">
        <div class="container index-product-container">
            <h2 class="index-title"><?= $productModel ? $productModel['title'] : '产品中心' ?></h2>
            <p class="index-title-brief">开放源代码的高端模板建站！响应式模板可用于企业建网站、专业建站！</p>
            <div class="row margin-0 index-product-box">
                <?php foreach ($productList as $item) { ?>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 index-product-card">
                    <div class="index-product-card-content">
                        <div class="index-product-card-thumb">
                            <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $item->id]) ?>">
                                <img alt="<?= $item->title ?>" src="<?= $item->thumb ?>">
                            </a>
                        </div>
                        <div class="index-product-card-main">
                            <div class="index-product-card-title"><?= $item->title ?></div>
                            <div class="index-product-card-brief">
                                <div class="index-product-card-brief-text">￥999 <span>起</span></div>
                                <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $item->id]) ?>" class="btn index-product-card-brief-btn">免费试用</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- <a href="#" class="index-product-btn">查看更多</a> -->
    </div>
    </div>
    <div class="index-news">
        <div class="container index-news-container">
            <h2 class="index-title"><?= $newsModel ? $newsModel['title'] : '新闻中心' ?></h2>
            <p class="index-title-brief">建网站、做网站相关教程、资讯等</p>
            <div class="row margin-0 index-news-box">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 index-news-card">
                    <div class="index-news-card-header">
                        <div class="index-news-card-header-btn">
                            <span class="index-news-card-header-btn-plus">+</span>
                            <span class="index-news-card-header-btn-text">快速建站</span>
                        </div>
                        <a href="#" class="index-news-card-header-link">查看更多>></a>
                    </div>
                    <?php foreach ($newsList as $item) { ?>
                        <div class="index-news-card-content">
                            <div class="index-news-card-content-main">
                                <div class="index-news-card-content-main-header">
                                    <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $item->id]) ?>" class="index-news-card-content-main-title"><?= $item['name'] ?></a>
                                    <div class="index-news-card-content-main-click"><?= date('Y-m-d', $item['created_at']) ?></div>
                                </div>
                                <div class="index-news-card-content-main-brief"><?= $item['brief'] ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 index-news-card index-news-card-center">
                    <div class="index-news-card-header">
                        <div class="index-news-card-header-btn">
                            <span class="index-news-card-header-btn-plus">+</span>
                            <span class="index-news-card-header-btn-text">建站直播</span>
                        </div>
                        <a href="#" class="index-news-card-header-link">查看更多>></a>
                    </div>
                    <?php foreach ($newsList as $item) { ?>
                        <div class="index-news-card-content index-news-card-content-center">
                            <div class="index-news-card-content-main">
                                <div class="index-news-card-content-main-header">
                                    <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $item->id]) ?>" class="index-news-card-content-main-title"><?= $item['name'] ?></a>
                                    <div class="index-news-card-content-main-click"><?= date('Y-m-d', $item['created_at']) ?></div>
                                </div>
                                <div class="index-news-card-content-main-brief"><?= $item['brief'] ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 index-news-card">
                    <div class="index-news-card-header">
                        <div class="index-news-card-header-btn">
                            <span class="index-news-card-header-btn-plus">+</span>
                            <span class="index-news-card-header-btn-text">资料阅读</span>
                        </div>
                        <a href="#" class="index-news-card-header-link">查看更多>></a>
                    </div>
                    <?php foreach ($newsList as $item) { ?>
                        <div class="index-news-card-content">
                            <div class="index-news-card-content-main">
                                <div class="index-news-card-content-main-header">
                                    <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $item->id]) ?>" class="index-news-card-content-main-title"><?= $item['name'] ?></a>
                                    <div class="index-news-card-content-main-click"><?= date('Y-m-d', $item['created_at']) ?></div>
                                </div>
                                <div class="index-news-card-content-main-brief"><?= $item['brief'] ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</section>
