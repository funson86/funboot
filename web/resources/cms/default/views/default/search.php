<?php
use frontend\helpers\Url;

$this->title = $keyword;

$this->registerMetaTag(["name" => "keywords", "content" => $store->settings['website_seo_title']]);
$this->registerMetaTag(["name" => "description", "content" => $store->settings['website_seo_description']]);
?>

<section id="content" class="page-section pt-4 search-section">

    <div class="container">

        <h1 class="text-center pt-5 pb-5"><?= Yii::t('app', 'Search') ?></h1>
        <?= \common\widgets\cms\Search::widget() ?>

        <?php if (count($models) > 0) { foreach ($models as $model) { ?>
        <div class="row main-content-card list-search-content-card">

            <div class="col-md-12 col-xs-12 col-lg-12 main-content-card-content list-search-content-card-content">
                <div class="main-content-card-content-title list-search-content-card-content-title"><a href="<?= Url::to(['/cms/default/page', 'id' => $model->id]) ?>"><?= $model->name ?></a></div>
                <div class="main-content-card-content-brief list-search-content-card-content-brief"><?php if (strlen($model->brief) > 5) echo $model->brief; else echo mb_substr($model->content, 0, 150) . '...'; ?></div>
            </div>

        </div>
        <?php } } else { ?>
        <div class="row margin-0 main-content-card list-search-content-card">
            <div class=""><?= Yii::t('app', 'No content contains') ?> [<span class="main-content-card-keyword text-red"><?= $keyword ?></span>]</div>
        </div>
        <?php } ?>

        <div class="pagination list-search-pagination">
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
        </div>
    </div>

</section>
