<?php

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = $model->name . ' - ' . $store->settings['website_seo_title'];
$this->params['breadcrumbs'][] = $model->name;

$this->registerMetaTag(["name" => "keywords", "content" => ($model->seo_keywords ? $model->seo_keywords : $store->settings['website_seo_keywords'])]);
$this->registerMetaTag(["name" => "description", "content" => ($model->seo_description ? $model->seo_description : $store->settings['website_seo_description'])]);
?>

<section id="content">

    <?= \common\widgets\cms\PortletTop::widget(['root' => $this->context->rootCatalog, 'portlet' => $this->context->portlet]) ?>

    <div class="main-content list-content">
        <div class="container list-container">
            <div class="row margin-0 main-content list-content">

                <div class="col-md-9 col-sm-9 col-xs-12 main-content-card-content list-content-card-content">
                    <div class="main-content-card-content-title list-main-content-card-content-title"><?= $model->name ?></div>

                    <?php foreach ($models as $model) { ?>
                    <div class="main-content-card-block list-content-card-content-card-block">
                        <div class="main-content-card-content-title list-content-card-content-title"><a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $model->id]) ?>"><?= $model->name ?></a></div>
                        <div class="main-content-card-content-brief list-content-card-content-brief"><?php if (strlen($model->brief) > 5) echo $model->brief; else echo mb_substr($model->content, 0, 150) . '...'; ?></div>
                        <div class="main-content-card-content-click list-content-card-content-click">
                            <i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDate($model->created_at) ?>
                            <i class="fa fa-eye"></i> <?= $model->click ?>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- 分页符设置 -->
                    <div class="list-pagination">
                        <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12 main-content-menu list-content-menu">

                    <?= \common\widgets\cms\Search::widget() ?>

                    <?= \common\widgets\cms\Portlet::widget(['portlet' => $this->context->portlet]) ?>

                    <?= \common\widgets\cms\Relate::widget(['models' => $relates]) ?>

                </div>

            </div>
        </div>
    </div>
</section>


