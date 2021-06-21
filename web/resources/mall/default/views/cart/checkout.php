<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
$this->registerCssFile('@web/css/checkout.css', ['depends' => \frontend\assets\MallAsset::className()]);
$allRegion = ArrayHelper::map(\common\models\Region::find()->asArray()->all(), 'id', 'name');
$totalProduct = 0;
$totalPrice = 0;
foreach($products as $product) {
    $totalProduct += $product->number;
    $totalPrice += $product->number * $product->price;
}
$shipmentFee = 0;
if ($totalPrice < Yii::$app->params['freeShipmentAmount']) {
    $shipmentFee = Yii::$app->params['defaultShipmentFee'];
}
$totalPrice += $shipmentFee;

$i = 0;
?>

<div id="main">
    <!-- 已登录状态 开始 -->
    <div class="user-tip cle">
        <div class="fl">Hi，<?= Yii::$app->user->identity->username ?>，请确认订单信息</div>
        <div class="fr"> <a class="graybtn" href="<?= Yii::$app->urlManager->createUrl(['/cart']) ?>">返回购物车修改</a> </div>
    </div>
    <div class="form_main">
        <?php $form = ActiveForm::begin(['id' => '']); ?>
        <?= Html::activeHiddenInput($model, 'payment_method', ['value' => \common\models\Order::PAYMENT_METHOD_PAY]) ?>
        <?= Html::activeHiddenInput($model, 'shipment_fee', ['value' => $shipmentFee]) ?>
            <div class="ck-box">
                <div class="hd cle">
                    <h3>确认收货人信息</h3>
                </div>
                <div class="addr-list">
                    <ul id="addr-list">
                        <?php foreach ($addresses as $address) { ?>
                        <li class='<?php if (!$i) echo 'selected'; ?>'>
                            <?= Html::radio('address_id', ($i === 0), [
                                'value' => $address->id,
                                'label' => null,
                            ]); ?>
                            <span class="addr-flag"><?= $address->name ?></span>
                            <span class="addr-con"><?= isset($allRegion[$address['country']]) ? $allRegion[$address['country']] : '' ?>&nbsp;<?= isset($allRegion[$address['province']]) ? $allRegion[$address['province']] : '' ?>&nbsp;<?= isset($allRegion[$address['city']]) ? $allRegion[$address['city']] : '' ?>&nbsp;<?= isset($allRegion[$address['district']]) ? $allRegion[$address['district']] : '' ?>&nbsp;<?= $address['address'] ?><em>（<?= $address['consignee'] ?>&nbsp;<?= $address['mobile'] ?>）</em></span> <a href="<?= Yii::$app->urlManager->createUrl(['cart/address', 'id' => $address->id]) ?>">修改</a>
                            <span class="addr-kdz" style="opacity:0;"><i></i>快递至：</span>
                        </li>
                        <?php  $i++;} ?>
                    </ul>
                </div>
                <div class="add-newaddr-line"> <a href="<?= Yii::$app->urlManager->createUrl(['cart/address']) ?>" id="add-newaddr">使用新地址</a> </div>
            </div>
            <!--div class="ck-box">
                <div class="hd cle">
                    <h3>确认送货方式</h3>
                </div>
                <div class="fahuo-list">
                    <div id="fahuo-list" class="fahuo-type">
                        <p> <a class="graybtn selected" id="1" lang="8" href="javascript:;"><i class="iconfont">$</i>网上支付-快递8元</a> </p>
                        <p> <a class="graybtn" id="2" lang="18" href="javascript:;"><i class="iconfont">$</i>货到付款-快递18元</a> <span class="gray">支持“银行卡刷卡” 和“现金”两种付款方式，在家等待快递公司送货上门，先验货后付款</span> </p>
                    </div>
                </div>
            </div-->
            <div class="ck-box">
                <div class="hd cle">
                    <h3>商品列表</h3>
                    <div class="fr"> <a class="graybtn" href="/cart">返回购物车修改</a> </div>
                </div>
                <div id="goods-list" class="goods-list">
                    <ul>
                        <li class="li_hd cle">
                            <div class="pic">商品</div>
                            <div class="name">&nbsp;</div>
                            <div class="price-xj">小计</div>
                            <div class="nums">数量</div>
                            <div class="price-one">单价</div>
                        </li>
                        <?php foreach ($products as $product) { ?>
                        <li class="cle">
                            <div class="pic"> <a target="_blank" href="<?= Yii::$app->urlManager->createUrl(['product/view', 'id' => $product->product_id]) ?>"> <img src="<?= $product->thumb ?>" alt="<?= $product->name ?>"> </a> </div>
                            <div class="name"> <a target="_blank" href="<?= Yii::$app->urlManager->createUrl(['product/view', 'id' => $product->product_id]) ?>"> <strong><?= $product->name ?> </strong></a></div>
                            <div class="price-xj"> ￥<em><?= $product->number * $product->price ?></em> </div>
                            <div class="nums"> <em><?= $product->number ?></em> </div>
                            <div class="price-one"> ￥<em><?= $product->price ?></em> </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <!--div class="list-count-bd cle">
                    <div class="coupon-canuse"> 可以使用优惠券的商品金额：￥<em id="coupon-canuse">7.99</em> </div>
                    <div class="list-count"> <em>1</em>件商品，活动优惠￥<em>0.00</em>，

                        总价：<span class="red">￥<em id="goods-price">7.99</em></span> </div>
                </div-->
            </div>
            <div class="user-other">
                <div id="use-coupon" class="use-dixiao cle" style="display: block;">
                    <span class="tit"><input type="checkbox" name="checkbox-coupon" id="checkbox-coupon"> 使用优惠券</span>
                    <span class="used"></span> <span class="gray again">【<a href="javascript:;">重新选择</a>】</span> <span class="gray cancel">【<a href="javascript:;">取消</a>】</span>
                    <div class="dixiao-tip"></div>
                </div>
                <div id="coupon_box" class="use_box">
                    <div class="coupon_list"></div>
                    <div class="line"></div>
                    <div class="coupon_code_box">
                        <h5><a id="coupon_code_trg" href="javascript:;">点击输入优惠券号码</a></h5>
                        <div id="coupon_code" class="use_box_form">
                            <input type="text" id="coupon-code-input" value="输入优惠券号码">
                            <a class="btn" id="coupon-code-submit" href="javascript:;">确定</a> </div>
                    </div>
                </div>
                <div id="use-integral" class="use-dixiao cle" <?php if (Yii::$app->user->identity->point > 0) { ?>style="display: block;"<?php } ?>>
                    <span class="tit"><input type="checkbox" name="checkbox-point" id="checkbox-point"> 使用积分</span>
                    <input type="hidden" value="<?= Yii::$app->user->identity->point ?>" name="user-point" id="user-point">
                    <span class="used"></span> <span class="gray cancel">【<a href="javascript:;">取消</a>】</span>
                    <div class="dixiao-tip"></div>
                </div>
                <div id="point_box" class="use_box">
                    <div class="arw"></div>
                    <h3>该订单可用积分：<span id="point-total" class="red"><?= Yii::$app->user->identity->point ?></span>，抵<span class="red">￥<?= Yii::$app->user->identity->point / 100 ?></span><a target="_blank" href="/help/member_integration.html">【如何获得积分？】</a></h3>
                    <div id="point-form" class="use_box_form">
                        <input type="text" value="">
                        <a class="btn" id="point-submit" href="javascript:;">确定</a> </div>
                </div>
                <!--div id="use-balance" class="use-dixiao cle">
                    <span class="tit"><input type="checkbox"> 使用账户余额</span>
                    <input type="hidden" value="" name="balance">
                    <span class="used"></span> <span class="gray cancel">【<a href="javascript:;">取消</a>】</span>
                    <div class="dixiao-tip"></div>
                </div-->
                <!--div id="balance_box" class="use_box">
                    <div class="arw"><i class="iconfont"></i></div>
                    <h3>该订单可用余额：<span class="red">￥<i id="balance-total">0.00</i></span><a target="_blank" href="/account/mine">【查看我的账户】</a></h3>
                    <div class="use_box_form">
                        <input type="text" value="">
                        <a class="btn" href="javascript:;">确定</a> </div>
                </div-->
                <!--div id="use-fapiao" class="use-dixiao cle">
                    <span class="tit"><input type="checkbox" name="fapiao"> 开具发票</span>
                    <span class="bd">
                        <input type="text" value="" class="txt" name="fapiao_title">
                        <span class="gray">日用品</span>
                    </span>
                    <span class="gray cancel">【<a href="javascript:;">取消</a>】</span>
                </div-->
            </div>
            <div id="postage-tip" class="postage-tip"> <em><?php if ($totalPrice >= Yii::$app->params['freeShipmentAmount']) { ?><span class="green">恭喜您，已免邮！</span><?php } else { ?><span class="red">运费<?= Yii::$app->params['defaultShipmentFee'] ?>元，满<?= Yii::$app->params['freeShipmentAmount'] ?>元包邮</span><?php } ?></em> </div>
            <div class="btm-box cle">
                <div class="other">
                    <dl class="cle">
                        <dt>备注：</dt>
                        <dd>
                            <?= Html::activeTextarea($model, 'remark', ['class' => 'txt', 'maxlength' => '100', 'style' => "color: rgb(51, 51, 51);"]) ?>
                        </dd>
                    </dl>
                </div>
                <div class="total-count">
                    <div class="tobe-pay">需支付： <?= Html::hiddenInput('totalPrice', $totalPrice) ?><span class="red">￥ <em id="total-price"><?= $totalPrice ?></em> </span> </div>
                    <p class="get-intg gray">可得积分：<?= intval($totalPrice) ?></p>
                    <div><?= Html::submitButton( Yii::t('app', '确认提交'), ['class' => 'btn',]) ?></div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- 已登录状态 end -->
    <!-- 未登录状态页面 end-->
</div>

<?php
$urlHelpCoupon = Yii::$app->urlManager->createUrl(['/cms/default/page', 'id' => 14, 'surname' => 'coupon']);
$urlCoupon = Yii::$app->urlManager->createUrl(['cart/json-coupon']);
$urlCouponCode = Yii::$app->urlManager->createUrl(['cart/ajax-coupon-code']);
$js = <<<JS
jQuery("[type='radio']").eq(0).prop("checked", 'checked');
jQuery("#addr-list li").eq(0).find(".addr-kdz").css('opacity', 1);
jQuery("#addr-list li").click(function(){
    jQuery("#addr-list li").removeClass('selected');
    jQuery("[type='radio']").removeAttr('checked');
    jQuery(".addr-kdz").css('opacity', 0);
    jQuery(this).addClass('selected');
    jQuery(this).find("input[type='radio']").prop("checked", 'checked');
    jQuery(this).find(".addr-kdz").css('opacity', 1);
});
jQuery("a.graybtn").click(function(){
    jQuery("a.graybtn").removeClass('selected');
    jQuery(this).addClass('selected');
    jQuery("#order-payment_method").val(this.id);
    jQuery("#order-shipment_fee").val(this.lang);
    jQuery("#postage-tip em").html("邮费：￥" + this.lang);
    jQuery("#total-price").html(parseInt(jQuery("[name='totalPrice']").val()) + parseInt(this.lang));
});
jQuery("input[name='checkbox-coupon']").click(function(){
    if ($("#checkbox-coupon").is(":checked")) {
        $.get("{$urlCoupon}", function(data, status) {
            if (status == "success") {
                var count = 0;
                var str = '<h3>该订单可用优惠券（<em class="red">' + data.count +'</em>）<a target="_blank" href="{$urlHelpCoupon}">【优惠券如何使用】</a></h3>';
                $.each(data.data, function(k, v) {
                    if (v.min_amount < parseInt($('#total-price').html())) {
                        count ++;
                        str += '<p style="margin-top:10px"><input type="checkbox" name="coupon" value="'+ v.id +'" data-money="' + parseInt(v.money) + '"> <span title="购物满' + parseInt(v.min_amount) + '减' + parseInt(v.money) + '购物券">' + parseInt(v.min_amount) + '-' + parseInt(v.money) + '优惠券</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;有效期至' + v.ended_time +'</p>';
                    }

                });
                $('.coupon_list').html(str);
            }
        });
        $('#coupon_box').css('display', 'block');
    } else {
        $('#coupon_box').css('display', 'none');
    }
});

jQuery(".coupon_list").on("click", 'input[name^=coupon]', function(){
    $("input[name='coupon']").removeAttr("checked");
    $(this).prop('checked', 'checked');
    money = parseInt($(this).data('money'));
    $("#total-price").html(parseFloat($("#total-price").html()) - money);
    $(".dixiao-tip").html("优惠券：<em>-￥" + money + ".00</em>");
    $(".dixiao-tip").css('display', 'block');
});

jQuery("#coupon_code_trg").click(function(){
    $("#coupon_code").css('display', 'block');
});

jQuery("#coupon-code-input").click(function(){
    this.value = '';
});

jQuery("#coupon-code-submit").click(function(){
    var couponCode = $(this).prev().val();
    $.get("{$urlCouponCode}?sn=" + couponCode, function(data, status) {
        if (status == "success") {
            if (parseInt(data.status) == -1) {
                alert('优惠码不存在');
            } else if (parseInt(data.status) == -2) {
                alert('优惠码已使用');
            } else if (parseInt(data.status) == -3) {
                alert('优惠码已过期');
            } else if (parseInt(data.status) == 1) {
                $("#coupon_code").html("优惠" + data.money + "元" + '<input type="hidden" name="sn" value="' + data.sn +'" />');
                $("#total-price").html(parseFloat($("#total-price").html()) - parseInt(data.money));
            }
        }
    });
});

jQuery("input[name='checkbox-point']").click(function(){
    if ($("#checkbox-point").is(":checked")) {
        $('#point_box').css('display', 'block');
    } else {
        $('#point_box').css('display', 'none');
    }
});
jQuery("#point-submit").click(function(){
    var usePoint = parseInt($(this).prev().val());
    var ownPoint = parseInt($("#user-point").val());
    if (usePoint > ownPoint) {
        alert('您本次最多可以使用' + ownPoint + '个积分');
    } else {
        var usePointYuan = usePoint / 100;
        $("#point-form").html("优惠" + usePointYuan + "元" + '<input type="hidden" name="point" value="' + usePoint +'" />');
        $("#total-price").html(parseFloat($("#total-price").html()) - usePointYuan);
    }
});

JS;

$this->registerJs($js);