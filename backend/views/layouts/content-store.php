<?php
use yii\bootstrap4\Breadcrumbs;
use common\helpers\Url;
?>

<div class="content-wrapper" style="overflow: auto; height: auto">
    <div class="wrapper" style="background: #f4f6f9">

        <?php if (!Yii::$app->request->isAjax) { ?>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <a href="<?= Yii::$app->request->getUrl(); ?>" class="fbRefreshBack">
                                <i class="icon ion-android-refresh"></i> <?= Yii::t('app', 'Refresh') ?>
                            </a>
                            <?php if (Yii::$app->request->referrer != Yii::$app->request->hostInfo . Yii::$app->request->getBaseUrl() . '/') { ?>
                                <a href="javascript:history.go(-1)" class="fbRefreshBack">
                                    <i class="icon ion-reply"></i> <?= Yii::t('app', 'Back') ?>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="col-6">
                            <?=
                            Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => Url::to(['/site/info'])],
                                'options' => [
                                    'class' => 'float-sm-right'
                                ]
                            ])
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>

        <section class="content">
            <div class="container-fluid">
                <?= $content ?>
                <?= !Yii::$app->request->isAjax ? \common\widgets\alert\SweetAlert2::widget() : '' ?>
            </div>
        </section>
    </div>
</div>

<footer class="main-footer">
    <strong>Version <?= Yii::$app->params['system_version'] ?>  Copyright &copy; <?= date('Y') ?> <a href="https://github.com/funson86/funboot">Funboot</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>

<script>
    let config = {
        isMobile: <?= \common\helpers\CommonHelper::isMobile() ? 'true' : 'false' ?>
    };
</script>

