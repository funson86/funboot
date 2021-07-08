<?php
use frontend\helpers\Url;

$this->title = $model->name;

$this->registerMetaTag(["name" => "keywords","content" => ($model->seo_keywords ? $model->seo_keywords : $store->settings['website_seo_keywords'])]);
$this->registerMetaTag(["name" => "description","content" => ($model->seo_description ? $model->seo_description : $store->settings['website_seo_description'])]);
?>

<section id="content" class="page-section bg-light pt-4">

    <div class="container">

        <?= \common\widgets\cms\PortletTop::widget(['root' => $this->context->rootCatalog, 'portlet' => $this->context->portlet]) ?>

        <div class="row main-content list-card-content">
            <div class="col-md-9">
                <div class="col-md-12 list-card bg-white">
                    <?php if (count($models)) { foreach ($models as $item) { ?>
                        <div class="media text-muted pt-3 border-bottom border-gray">
                            <div class="media-body pb-3 mb-0 small lh-125">
                                <h5><a href="<?= Url::to(['/cms/default/page', 'id' => $item->id]) ?>"><?= $item->name ?></a></h5>
                                <p class="mb-1"><?= strlen($item->brief) > 5 ? $item->brief : mb_substr($item->content, 50) . '...' ?></p>
                                <p class="m-0"><span class="list-card-date"><?= date('m-d') ?> /</span> <?= date('Y') ?></p>
                            </div>
                            <div class="bd-placeholder-img pl-3 pr-3 mt-4 rounded"><a href="<?= Url::to(['/cms/default/page', 'id' => $item->id]) ?>" class="btn btn-light btn-sm btn-more" style="border: 1px solid #ccc"><?= Yii::t('app', 'More') ?></a> </div>
                        </div>
                        <div class="media text-muted pt-3">
                            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <h5>@username</h5>
                                <p>Playing ping pong all night long, everything's all neon and hazy. Yeah, she's so in demand. She's sweet as pie but if you break her heart. But down to earth. It's time to face the music I'm no longer your muse. I guess that I forgot I had a choice.</p>
                            </div>
                            <div class="bd-placeholder-img pl-3 pr-3 mt-4 rounded"> <a href="#" class="btn btn-light btn-sm btn-more" style="border: 1px solid #ccc"><?= Yii::t('app', 'More') ?></a> </div>
                        </div>
                    <?php } } else { ?>
                    <?php } ?>
                </div>

                <div class="pagination list-product-pagination">
                    <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
                </div>
            </div>

            <div class="col-md-3 bg-white pt-3">
                <?= \common\widgets\cms\Search::widget() ?>

                <?= \common\widgets\cms\Portlet::widget(['root' => $this->context->rootCatalog, 'portlet' => $this->context->portlet]) ?>

                <?= \common\widgets\cms\Relate::widget(['allCatalog' => $this->context->allCatalog, 'catalogId' => $model->id, ]) ?>
            </div>
        </div>
    </div>
</section>


