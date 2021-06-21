<?php
/* @var $this yii\web\View */
$this->registerCssFile('@web/css/cod.css', ['depends' => \frontend\assets\MallAsset::className()]);
?>

<div id="main">
    <div class="acknowledgement">
        <p class="msg"><span class="ico_ok"></span>订单提交成功！</p>
        <p class="info"> 到货后需支付:<span class="price">¥<em><?= $model->amount ?></em></span><span class="gray"> 并将在交易成功后获得<span><?= intval($model->amount) ?>商城积分</span></span><br>
            <label>您的订单号：<span><?= $model->sn ?></span></label>
            <a target="_blank" class="view_detail" href="<?= Yii::$app->urlManager->createUrl(['/order/view', 'id' => $model->id]) ?>">查看订单详情</a> </p>
    </div>
    <div class="shuom">
        <ul>
            <li><a title="购买的商品不满意怎么办" target="_blank" href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => 13, 'surname' => 'point']) ?>"><img width="324" height="67" src="/images/order_shuo_01.jpg" alt="购买的商品不满意怎么办" title="购买的商品不满意怎么办"></a></li>
            <li><a title="积分使用办法" target="_blank" href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => 13, 'surname' => 'point']) ?>"><img width="324" height="67" src="/images/order_shuo_02.jpg" alt="积分使用办法" title="积分使用办法"></a></li>
            <li style="margin: 0;"><a title="分享购买的商品" href="<?= Yii::$app->urlManager->createUrl(['product/search']) ?>"><img width="324" height="67" src="/images/order_shuo_03.jpg" alt="分享购买的商品" title="分享购买的商品"></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
