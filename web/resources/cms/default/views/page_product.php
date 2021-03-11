<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use funson86\blog\Module;

$this->title = $model->name . ' - ' . $store->settings['website_seo_title'];

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
        <div class="sub-menu page-product-sub-menu">
            <ul class="sub-menu-content page-product-sub-menu-content">
                <?php foreach ($portlet as $item) { ?>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['site/' . $item['type'], 'id' => $item['id']]) ?>"><?= $item['title'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>


    <div class="main-content page-product-content">
        <div class="container page-product-container">
            <div class="main-content-title page-product-main-content-title"><?= $model->name ?></div>

            <div class="main-content-content page-product-main-content-content">
                <p><?= $model->content ?></p>
            </div>

            <div class="row margin-0 main-content-relative page-product-content-relative">
                <div class="col-md-5 col-xs-11 main-content-relative-left  page-product-content-relative-left">
                    上一篇：<?php if (isset($prev)) { ?><a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $prev->id]) ?>" color-blue> <?=$prev->title ?> </a> <?php } else echo '没有了'; ?>
                </div>
                <div class="col-md-5 col-xs-11 main-content-relative-right page-product-content-relative-right">
                    下一篇：<?php if (isset($next)) { ?><a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $next->id]) ?>" color-blue> <?=$next->title ?> </a> <?php } else echo '没有了'; ?>
                </div>
            </div>

        </div>

    </div>

</section>
