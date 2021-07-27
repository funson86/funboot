<?php
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\bootstrap4\Breadcrumbs;
use common\helpers\Url;

?>
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
        <?= !Yii::$app->request->isAjax ? \common\widgets\alert\SweetAlert2::widget() : '' ?>
        <?= $content ?>
    </div>
</section>

