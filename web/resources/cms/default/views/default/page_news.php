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


    <div class="main-content page-news-content">
        <div class="container page-news-container">
            <div class="main-content-title page-news-main-content-title"><?= $model->name ?></div>

            <div class="main-content-click page-news-main-content-click"><i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDate($model->created_at) ?> &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-eye"></i> 点击数: <?= $model->click ?></div>

            <div class="main-content-content page-news-main-content-content">
                <p><?= $model->content ?></p>
            </div>
            <div class="row margin-0 main-content-relative page-news-content-relative">
                <div class="col-md-5 col-xs-11 main-content-relative-left  page-news-content-relative-left">
                    上一篇：<?php if (isset($prev)) { ?><a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $prev->id]) ?>" color-blue> <?=$prev->title ?> </a> <?php } else echo '没有了'; ?>
                </div>
                <div class="col-md-5 col-xs-11 main-content-relative-right page-news-content-relative-right">
                    下一篇：<?php if (isset($next)) { ?><a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $next->id]) ?>" color-blue> <?=$next->title ?> </a> <?php } else echo '没有了'; ?>
                </div>
            </div>

        </div>

    </div>
</section>
