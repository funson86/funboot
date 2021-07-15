<?php
use common\models\cms\Page;

/* @var $this yii\web\View */
/* @var $context \frontend\controllers\BaseController */
$this->title = $context->getBlockValue('common_website_name') ?: '';

$store = $this->context->store;
$context = $this->context;
?>

<section class="page-section bg-light text-dark">

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">
        <div class="container marketing">

            <h1 class="text-center pb-5"><?= $context->getBlockValue('home_service') ?></h1>

            <!-- Three columns of text below the carousel -->
            <div class="row text-center">
                <?php for ($i = 0; $i < 3; $i++) { ?>
                <div class="col-lg-4 wow fadeIn<?= $i == 0 ? 'Left' : ($i == 2 ? 'Right' : 'Up') ?>">
                    <div class="icon-block mb-2"><i class="fa <?= $context->getBlockFieldIndex($i, 'home_service', 'param1') ?>"></i></div>
                    <h3 class="mb-2"><?= $context->getBlockValueIndex($i, 'home_service', 'brief') ?></h3>
                    <p><?= $context->getBlockValueIndex($i, 'home_service', 'content') ?></p>
                </div><!-- /.col-lg-4 -->
                <?php } ?>
            </div><!-- /.row -->
        </div>

    </div><!-- /.container -->

</section>

<?php if (true) { $models = Page::findAll(['store_id' => Yii::$app->storeSystem->getId(), 'id' => ['251675914331488256', '251675417226772480', '251674778652377088']]); if (count($models)) { ?>
<section class="page-section bg-white text-center">
    <div class="container">
        <div class="flexslider">
            <ul class="slides">
                <?php foreach ($models as $model) { ?>
                <li data-thumb="<?= $model->thumb ?>">
                    <img src="<?= $model->thumb ?>" />
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>
<?php } } ?>

<?php if (true) { ?>
<section class="page-section bg-dark text-light" style="background: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)), url(<?= nl2br($context->getBlockValue('home_board', 'thumb')) ?>) center center;">
    <div class="container">
        <div class="row featurette ads">
            <div class="col-md-12 wow fadeInUp">
                <h3 class="mb-4"><?= nl2br($context->getBlockValue('home_board', 'content')) ?></h3>
            </div>
        </div>
    </div>
</section>
<?php } ?>

<section class="page-section bg-white text-center" id="about">
    <div class="container">

        <h1 class="text-center pb-5"><?= $context->getBlockValue('home_about_us') ?></h1>

        <div class="row featurette">
            <div class="col-md-6 wow fadeInLeft mb-3">
                <h2 class="text-lg-left"><?= $context->getBlockValue('home_about_us', 'brief') ?></h2>
                <p class="lead text-lg-left"><?= nl2br($context->getBlockValue('home_about_us', 'content')) ?></p>
            </div>
            <div class="col-md-6 wow fadeInRight">
                <img src="<?= nl2br($context->getBlockValue('home_about_us', 'thumb')) ?>" class="img-fluid img-square" />
            </div>
        </div>

    </div>
</section>

<section class="page-section bg-light" id="contact">
    <div class="container">
        <h1 class="text-center pb-5"><?= $context->getBlockValue('home_contact_us') ?></h1>
        <div class="row featurette">

            <div class="col-xs-6 col-sm-6 col-md-3 contact-info text-center wow bounceIn" data-wow-duration="3s">
                <i class="fa fa-envelope-o"></i>
                <h4 class="contact_title"><?= Yii::t('cms', 'Email') ?></h4>
                <p class="contact_description"><?= $context->getBlockValueIndex(0, 'home_contact_us', 'brief') ?></p>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 contact-info text-center wow bounceIn" data-wow-duration="3s">
                <i class="fa fa-map-marker"></i>
                <h4 class="contact_title"><?= Yii::t('cms', 'Address') ?></h4>
                <p class="contact_description"><?= $context->getBlockValueIndex(1, 'home_contact_us', 'brief') ?></p>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 contact-info text-center wow bounceIn" data-wow-duration="3s">
                <i class="fa fa-phone"></i>
                <h4 class="contact_title"><?= Yii::t('cms', 'Call Us') ?></h4>
                <p class="contact_description"><?= $context->getBlockValueIndex(2, 'home_contact_us', 'brief') ?></p>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 contact-info text-center wow bounceIn" data-wow-duration="3s">
                <i class="fa fa-weixin"></i>
                <h4 class="contact_title"><?= Yii::t('cms', 'WeChat') ?></h4>
                <p class="contact_description"><?= $context->getBlockValueIndex(3, 'home_contact_us', 'brief') ?></p>
            </div>

        </div>
    </div>
</section>

<?php if (strlen($store->settings['website_map']) > 5) { ?>
<section class="page-section bg-light pt-0" id="home-map">
    <div class="container-fluid p-0" style="overflow: hidden; height: 100%">
        <?= $store->settings['website_map'] ?>
    </div>
</section>
<?php } ?>
