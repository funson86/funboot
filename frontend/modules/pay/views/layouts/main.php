<?php
use yii\helpers\Html;
use common\widgets\adminlte\AdminlteLoginAsset;
use common\widgets\adminlte\AdminltePayAsset;
use frontend\assets\PayAsset;

/* @var $this \yii\web\View */
/* @var $content string */

PayAsset::register($this);

$store = $this->context->store;

$this->title = strlen($store->settings['website_seo_title']) > 5 ? $store->settings['website_seo_title'] : $store->name;

?>

<?php $this->beginPage() ?>
<html lang="en">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?= $this->title ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition layout-top-nav funpay">
<?php $this->beginBody() ?>
<div class="wrapper">

    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="<?= Yii::$app->urlManager->createUrl(['/']) ?>" class="navbar-brand">
                <img src="<?= $store->settings['website_logo'] ?: Yii::$app->params['defaultWebsiteLogo'] ?>" alt="Funpay" class="brand-image img-circle elevation-3"
                     style="opacity: .8">
                <span class="brand-text font-weight-light">FunPay</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?= Yii::$app->urlManager->createUrl(['/']) ?>" class="nav-link"><?= Yii::t('app', 'Home') ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Yii::$app->urlManager->createUrl(['/pay/default/pay']) ?>" class="nav-link"><?= Yii::t('app', '支付体验') ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Yii::$app->urlManager->createUrl(['/pay/default/list']) ?>" class="nav-link"><?= Yii::t('app', '捐赠名单') ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="https://github.com/funson86/funboot/" target="_blank" class="nav-link"><?= Yii::t('app', 'Funboot开发平台') ?></a>
                    </li>
                </ul>
            </div>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/funson86/funboot/" target="_blank"><i class="fab fa-github"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/funson86" target="_blank"><i class="fas fa-user-alt"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fab fa-qq"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media text-center" style="text-align: center; align-items: center">
                                <img src="/resources/images/funboot-qq-qun.png">
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="https://jq.qq.com/?_wv=1027&k=OZ8X3qjK" target="_blank" class="dropdown-item dropdown-footer">QQ 群：798843502</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?= $content ?>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <!-- To the right -->
        <!--div class="float-right d-none d-sm-inline">
            FunPay
        </div-->
        <!-- Default to the left -->
        <strong>Copyright &copy; <?= date('Y') ?> <a href="https://funpay.mayicun.com">FunPay</a>.</strong> All rights reserved.
    </footer>

</div>
<!-- ./wrapper -->

<script>
    // 配置
    let config = {
        isMobile: <?= \common\helpers\CommonHelper::isMobile() ? 'true' : 'false' ?>
    };
</script>

<!-- REQUIRED SCRIPTS -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
