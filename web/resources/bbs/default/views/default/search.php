<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use funson86\cms\Module;

$this->title = $keyword . ' - ' . $store->settings['website_seo_title'];
$this->params['breadcrumbs'][] = '文章';

$this->registerMetaTag(["name" => "keywords","content" => $store->settings['website_seo_title']]);
$this->registerMetaTag(["name" => "description","content" => $store->settings['website_seo_description']]);
?>

<section id="content">

    <div class="main-content list-search-content">
        <div class="list-search-title">站内搜索</div>

        <div class="container list-search-container">

            <?= \common\widgets\cms\Search::widget() ?>

            <?php if (count($models) > 0) { foreach ($models as $model) { ?>
                <div class="row margin-0 main-content-card list-search-content-card">

                    <div class="col-md-12 col-xs-12 col-lg-12 main-content-card-content list-search-content-card-content">
                        <div class="main-content-card-content-title list-search-content-card-content-title"><a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $model->id]) ?>"><?= $model->name ?></a></div>
                        <div class="main-content-card-content-url list-search-content-card-content-url"><a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $model->id]) ?>"><?= Yii::$app->urlManager->createAbsoluteUrl(['cms/default/page', 'id' => $model->id]) ?></a></div>
                        <div class="main-content-card-content-brief list-search-content-card-content-brief"><?php if (strlen($model->brief) > 5) echo $model->brief; else echo mb_substr($model->content, 0, 150) . '...'; ?></div>
                    </div>

                </div>
            <?php }} else { ?>
                <div class="row margin-0 main-content-card list-search-content-card">
                    没有含[<span class="main-content-card-keyword list-search-content-card-keyword"><?= $keyword ?></span>]的信息内容
                </div>
            <?php } ?>
        </div>
        <!-- 分页符设置 -->
        <div class="list-search-pagination">
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
        </div>
    </div>
</section>


