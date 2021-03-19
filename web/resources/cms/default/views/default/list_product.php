<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use funson86\cms\Module;

$this->title = $model->name . ' - ' . $store->settings['website_seo_title'];
$this->params['breadcrumbs'][] = '文章';

$this->registerMetaTag(["name" => "keywords","content" => ($model->seo_keywords ? $model->seo_keywords : $store->settings['website_seo_keywords'])]);
$this->registerMetaTag(["name" => "description","content" => ($model->seo_description ? $model->seo_description : $store->settings['website_seo_description'])]);
?>

<?php if (strlen($model->banner) > 5) { ?>
    <section id="banner">
        <img src="<?= $model->banner ?>">
    </section>
<?php } ?>


<section id="content">

    <?php if (count($portlet) > 1) { ?>
        <div class="sub-menu list-product-sub-menu">
            <ul class="sub-menu-content list-product-sub-menu-content">
                <?php foreach ($portlet as $item) { ?>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['site/' . $item['type'], 'id' => $item['id']]) ?>"><?= $item['title'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>


    <div class="main-content list-product-content">
        <div class="container list-product-container">
            <?php foreach ($models as $model) { ?>
                <div class="col-md-4 col-sm-6 col-xs-6 list-product-card">
                    <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $model->id]) ?>">
                        <div class="list-product-card-thumb"><img  src="<?= $model->thumb ?>" alt=""></div>
                        <div class="list-product-card-title"><a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $model->id]) ?>"><?= $model->name ?></div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <!-- 分页符设置 -->
        <div class="pagination list-product-pagination">
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
        </div>
    </div>
</section>


