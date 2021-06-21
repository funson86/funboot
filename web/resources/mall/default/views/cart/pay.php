<?php
use common\models\Region;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->registerCssFile('@web/css/pay.css', ['depends' => \frontend\assets\MallAsset::className()]);
$query = new \yii\db\Query();
$result = $query->select('sum(number) as number')->from('order_product')->where(['order_id' => $model->id])->createCommand()->queryOne();
$totalNumber = $result['number'];
?>

<div id="main">
    <!-- 订单信息 -->
    <div class="trade-info">
        <h4><?= Yii::$app->user->identity->username ?>，订单已成功提交，请付款！<span class="gray">24小时内未付款，我们将关闭交易 &gt;_&lt;</span></h4>
        <div class="trade-total"> <b>需支付：</b>￥<strong id="pay-total"><?= $model->amount ?></strong> <span class="gray">完成交易可获得<span><?= intval($model->amount) ?></span>商城积分</span> </div>
        <div class="trade-intro"> 您的订单号：<?= $model->sn ?> <a id="trade-showbtn" class="trade-showbtn" href="javascript:;"><i></i>查看订单详情</a>
            <div class="trade-detail">
                <table>
                    <tbody>
                    <tr>
                        <td class="tl">购买商品：</td>
                        <td><?= $totalNumber ?> 件&nbsp;&nbsp;&nbsp;&nbsp;应付款：¥ <em><?= $model->amount ?></em></td>
                    </tr>
                    <tr>
                        <td class="tl">购买时间：</td>
                        <td><?= Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                    </tr>
                    <tr>
                        <td class="tl">收货地址：</td>
                        <td> <?= $model->country ? Region::findOne($model->country)->name : '' ?> <?= $model->province ? Region::findOne($model->province)->name : '' ?> <?= $model->city ? Region::findOne($model->city)->name : '' ?> <?= $model->district ? Region::findOne($model->district)->name : '' ?>&nbsp;&nbsp;<?= $model->address ?>&nbsp;（<?= $model->mobile ?>）
                            <p><a class="graybtn" target="_blank" href="<?= Yii::$app->urlManager->createUrl(['/order']) ?>">进入我的订单</a></p></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'payform', 'action' => Yii::$app->urlManager->createUrl(['pay/submit']), 'options' => ['name' => 'payform', 'target' => '_blank']]); ?>
        <?= \yii\helpers\Html::hiddenInput('sn', Yii::$app->request->get('sn')) ?>
        <div id="pay-box" class="pay-box cle">
            <dl class="platform">
                <dt><b>平台支付</b>支持所有银行卡或信用卡，更迅速、安全</dt>
                <dd>
                    <ul class="methods_info">
                        <li>
                            <div class="banks-bd selected">
                                <input type="radio" value="ALIPAY" checked="checked" name="channel">
                                <label class="alipay_sm"></label>
                            </div>
                            <p class="info">支持国内外160多家银行<br>
                                以及VISA、MasterCard</p>
                        </li>
                    </ul>
                </dd>
            </dl>
        </div>
    <?php ActiveForm::end(); ?>
    <div class="pay_line">
        支付<span class="red">￥<em><?= $model->amount ?></em></span></span>
        <a href="javascript:;" id="pay-btn" class="btn">
            去付款<i class="glyphicon glyphicon-chevron-right"></i>
        </a>
    </div>
</div>

<div id="bg"></div>
<div id="show">
    <div class="pay_tipwin">
        <h3>请您在新开页面中完成支付。</h3>
        <p>支付完成前请不要关闭此窗口。</p>
        <p>完成支付后请点击下面的按钮。</p>

        <p class="btn-p">
            <a class="btn" href="<?= Yii::$app->urlManager->createUrl('/order') ?>">支付完成</a>
            <a class="btn btnReturn" href="javascipt:;">支付遇到问题</a>
        </p>
    </div>
</div>

<?php
$urlCoupon = Yii::$app->urlManager->createUrl(['cart/json-coupon']);
$urlCouponCode = Yii::$app->urlManager->createUrl(['cart/ajax-coupon-code']);
$urlPaySubmit = Yii::$app->urlManager->createUrl(['cart/pay-submit']);
$js = <<<JS
jQuery("#trade-showbtn").click(function(){
    if ($('.trade-detail').css('display') == 'none') {
        $('.trade-detail').css('display', 'block');
    } else {
        $('.trade-detail').css('display', 'none');
    }
});
jQuery("#pay-btn").click(function(){
    $("#bg").css('display', 'block');
    $("#show").css('display', 'block');
    $("#payform").submit();
});
jQuery(".btnReturn").click(function(){
    $("#bg").css('display', 'none');
    $("#show").css('display', 'none');
});
JS;

$this->registerJs($js);