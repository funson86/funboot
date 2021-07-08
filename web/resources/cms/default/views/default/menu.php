<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use funson86\blog\Module;

$this->title = $model->name;
$this->params['breadcrumbs'][] = $model->name;

$this->registerMetaTag(["name" => "keywords","content" => ($model->seo_keywords ? $model->seo_keywords : $store->settings['website_seo_keywords'])]);
$this->registerMetaTag(["name" => "description","content" => ($model->seo_description ? $model->seo_description : $store->settings['website_seo_description'])]);
?>

<section id="content" class="page-section pt-4">
    <div class="container">

        <?= \common\widgets\cms\PortletTop::widget(['root' => $this->context->rootCatalog, 'portlet' => $this->context->portlet]) ?>

        <h2 class="text-center pt-5 pb-5 main-content-title menu-main-content-title"><?= $model->name ?></h2>

        <div class="main-content-content menu-product-main-content-content">
            <p><?= $model->content ?></p>
        </div>

    </div>
</section>

