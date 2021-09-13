<?php
use yii\helpers\Url;
?>

<div class="container footer">
    <div class="row">
        <div class="col-md-12 text-center">
            © <?= $this->context->store->name ?> <?= date('Y') ?> All Right Reserved.
        </div>
    </div>
</div>

<div class="btn-group-vertical" id="floatButton">
    <button type="button" class="btn btn-light" id="goTop" title="<?= Yii::t('app', 'Go Top') ?>"><span class="bi-arrow-up"></span></button>
    <button type="button" class="btn btn-light" id="refresh" title="<?= Yii::t('app', 'Refresh') ?>"><span class="bi-arrow-clockwise"></span></button>
    <button type="button" class="btn btn-light" id="pageQrcode" title="<?= Yii::t('app', 'Qrcode') ?>"><span class="bi-upc-scan"></span>
        <img class="qrcode" width="130" height="130" src="<?= Url::to(['/site/qr', 'text' => Yii::$app->request->absoluteUrl]) ?>"/>
    </button>
    <button type="button" class="btn btn-light" id="goBottom" title="<?= Yii::t('app', 'Go Bottom') ?>"><span class="bi-arrow-down"></span></button>
</div>

