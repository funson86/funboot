<?php
use frontend\helpers\Url;

$this->title = $model->name;

$this->registerMetaTag(["name" => "keywords", "content" => ($model->seo_keywords ? $model->seo_keywords : $store->settings['website_seo_keywords'])]);
$this->registerMetaTag(["name" => "description", "content" => ($model->seo_description ? $model->seo_description : $store->settings['website_seo_description'])]);
?>

<section id="content" class="page-section bg-light pt-4">
    <div class="container pl-5 pr-5">

        <?= \common\widgets\cms\PortletTop::widget(['root' => $this->context->rootCatalog, 'portlet' => $this->context->portlet, 'page' => $model]) ?>

        <div class="bg-white page-main-content">
            <div class="row">
                <div class="col-md-12 p-5">
                    <h2 class="text-center"><?= $model->name ?></h2>

                    <div class="text-center pb-3 border-bottom border-gray"><i class="fa fa-clock-o"></i> <?= date('Y-m-d H:i') ?> / <?= $model->catalog->name ?></div>

                    <div class="pt-3 page-main-content-content">
                        <p><?= $model->content ?></p>
                    </div>

                </div>

            </div>

            <div class="row p-3 page-news-content-relative">
                <div class="col-md-6 col-xs-12 mb-3 text-left page-news-content-relative-left">
                    <?= Yii::t('app', 'Previous One') ?>: <?php if (isset($prev)) { ?><a href="<?= Url::to(['/cms/default/page', 'id' => $prev->id]) ?>"> <?=$prev->title ?> </a> <?php } else echo '-'; ?>
                </div>
                <div class="col-md-6 col-xs-12 mb-3 text-right page-news-content-relative-right">
                    <?= Yii::t('app', 'Next One') ?>: <?php if (isset($next)) { ?><a href="<?= Url::to(['/cms/default/page', 'id' => $next->id]) ?>"> <?=$next->title ?> </a> <?php } else echo '-'; ?>
                </div>
            </div>

        </div>

    </div>
</section>
