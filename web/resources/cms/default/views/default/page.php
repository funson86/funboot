<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use funson86\blog\Module;

$this->title = $model->name . ' - ' . $store->settings['website_seo_title'];

$this->registerMetaTag(["name" => "keywords","content" => ($model->seo_keywords ? $model->seo_keywords : $store->settings['website_seo_keywords'])]);
$this->registerMetaTag(["name" => "description","content" => ($model->seo_description ? $model->seo_description : $store->settings['website_seo_description'])]);
?>

<section id="content">

    <?= \common\widgets\cms\PortletTop::widget(['root' => $this->context->rootCatalog, 'portlet' => $this->context->portlet]) ?>

    <div class="main-content page-content">
        <div class="container page-container">
            <div class="main-content-title page-main-content-title"><?= $model->name ?></div>

            <div class="main-content-content page-main-content-content">
                <p><?= $model->content ?></p>
            </div>
        </div>

    </div>

</section>
