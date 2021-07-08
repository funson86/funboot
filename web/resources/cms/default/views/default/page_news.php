<?php
use frontend\helpers\Url;

$this->title = $model->name;

$this->registerMetaTag(["name" => "keywords", "content" => ($model->seo_keywords ? $model->seo_keywords : $store->settings['website_seo_keywords'])]);
$this->registerMetaTag(["name" => "description", "content" => ($model->seo_description ? $model->seo_description : $store->settings['website_seo_description'])]);
?>

<section id="content" class="page-section pt-4">
    <div class="container">

        <?= \common\widgets\cms\PortletTop::widget(['root' => $this->context->rootCatalog, 'portlet' => $this->context->portlet, 'page' => $model]) ?>

        <h2 class="text-center pt-5 pb-5"><?= $model->name ?></h2>

        <div class="main-content-content page-product-main-content-content">
            <p><?= $model->content ?></p>
        </div>

        <div class="row p-0 page-news-content-relative">
            <div class="col-md-6 col-xs-12 mb-3 text-left page-news-content-relative-left">
                <?= Yii::t('app', 'Previous One') ?>: <?php if (isset($prev)) { ?><a href="<?= Url::to(['/cms/default/page', 'id' => $prev->id]) ?>"> <?=$prev->title ?> </a> <?php } else echo '-'; ?>
            </div>
            <div class="col-md-6 col-xs-12 mb-3 text-right page-news-content-relative-right">
                <?= Yii::t('app', 'Next One') ?>: <?php if (isset($next)) { ?><a href="<?= Url::to(['/cms/default/page', 'id' => $next->id]) ?>"> <?=$next->title ?> </a> <?php } else echo '-'; ?>
            </div>
        </div>

    </div>
</section>
