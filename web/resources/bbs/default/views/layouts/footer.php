<?php
use yii\helpers\Url;
?>

<div class="container footer">
    <div class="row">
        <dl class="col-sm-3">
            <dt>网站信息</dt>
            <dd><a href="<?= Url::to(['/bbs/users']) ?>">活跃会员</a></dd>
        </dl>
        <dl class="col-sm-3">
            <dt>相关合作</dt>
            <dd><a href="/contact">联系我们</a></dd>
        </dl>
        <dl class="col-sm-3">
            <dt>关注我们</dt>
            <dd><a href="/about">关于我们</a></dd>
        </dl>
        <dl class="col-sm-3">
            <dt> 技术采用</dt>
            <dd class="fs12">
                由 <a href="https://github.com/funson86">Funson</a> 创建 项目地址: <a href="https://github.com/funson86/funboot">Funboot</a>
                <br>
                技术支持 <a href="http://www.yiiframework.com/" rel="external">Yii 框架</a> 2.0.x                    <br>
                © Funboot <?= date('Y') ?> All Right Reserved.</dd>
        </dl>
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

