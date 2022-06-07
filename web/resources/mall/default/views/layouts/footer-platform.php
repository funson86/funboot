<?php
use yii\helpers\Url;
?>

<div class="container footer">
    <div class="row">
        <div class="col-md-12 text-center">
            © <?= $this->context->store->name ?> <?= date('Y') ?> <?= Yii::t('app', 'All Right Reserved.') ?>
        </div>
    </div>
</div>

<div class="btn-group-vertical" id="floatButton">
    <button type="button" class="btn btn-light" id="goTop" title="<?= Yii::t('app', 'Go Top') ?>"><span class="fa fa-chevron-up"></span></button>
    <button type="button" class="btn btn-light" id="refresh" title="<?= Yii::t('app', 'Refresh') ?>"><span class="fa fa-refresh"></span></button>
    <button type="button" class="btn btn-light" id="pageQrcode" title="<?= Yii::t('app', 'Qrcode') ?>"><span class="fa fa-qrcode"></span>
        <img class="qrcode" width="130" height="130" src="<?= Url::to(['/site/qr', 'text' => Yii::$app->request->absoluteUrl]) ?>"/>
    </button>
    <button type="button" class="btn btn-light" id="goBottom" title="<?= Yii::t('app', 'Go Bottom') ?>"><span class="fa fa-chevron-down"></span></button>
</div>

