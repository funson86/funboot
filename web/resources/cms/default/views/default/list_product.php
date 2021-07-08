<?php
use frontend\helpers\Url;

$this->title = $model->name;

$this->registerMetaTag(["name" => "keywords","content" => ($model->seo_keywords ? $model->seo_keywords : $store->settings['website_seo_keywords'])]);
$this->registerMetaTag(["name" => "description","content" => ($model->seo_description ? $model->seo_description : $store->settings['website_seo_description'])]);
?>

<section id="content" class="page-section pt-4">

    <div class="container">

        <?= \common\widgets\cms\PortletTop::widget(['root' => $this->context->rootCatalog, 'portlet' => $this->context->portlet]) ?>

        <h1 class="text-center pt-5 pb-5"><?= $model->name ?></h1>

        <div class="row text-center list-product-content list-product-container">
            <?php foreach ($models as $model) { ?>
            <div class="col-md-4 col-sm-6 col-xs-6 list-product-card p-5">
                <a href="<?= Url::to(['/cms/default/page', 'id' => $model->id]) ?>">
                    <div class="list-product-card-thumb"><img src="<?= $model->thumb ?>" alt="" /></div>
                    <div class="list-product-card-title"><a href="<?= Url::to(['/cms/default/page', 'id' => $model->id]) ?>"><?= $model->name ?></div>
                </a>
            </div>
            <?php } ?>

            <div class="pagination list-product-pagination">
                <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
            </div>
        </div>

    </div>
</section>


