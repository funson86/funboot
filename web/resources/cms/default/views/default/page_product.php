<?php
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = $model->name;

$this->registerMetaTag(["name" => "keywords", "content" => ($model->seo_keywords ? $model->seo_keywords : $store->settings['website_seo_keywords'])]);
$this->registerMetaTag(["name" => "description", "content" => ($model->seo_description ? $model->seo_description : $store->settings['website_seo_description'])]);

?>

<section id="content" class="page-product-section pt-4">
    <div class="container">

        <?= \common\widgets\cms\PortletTop::widget(['root' => $this->context->rootCatalog, 'portlet' => $this->context->portlet, 'page' => $model]) ?>

        <h2 class="text-center pt-5 pb-5"><?= $model->name ?></h2>

        <?php if (is_array($model->images) && count($model->images) > 0) { ?>
        <div class="flexslider">
            <ul class="slides">
                <?php foreach ($model->images as $item) { ?>
                    <li data-thumb="<?= $item ?>">
                        <img src="<?= $item ?>" />
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php } elseif (strlen($model->thumb) > 5) { ?>
        <div class="text-center p-5"><img src="<?= $model->thumb ?>" /></div>
        <?php } ?>

        <div class="main-content-content page-product-main-content-content">
            <p><?= $model->content ?></p>
        </div>

    </div>
</section>
