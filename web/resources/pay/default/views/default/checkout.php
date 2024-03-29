<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\pay\Payment as ActiveModel;
use common\helpers\CommonHelper;

/* @var $this yii\web\View */
/* @var $model common\models\pay\Payment */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'FunPay收银台 收款方: ') . (Yii::$app->params['funPay']['adminName'] ?? 'Funpay');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$context = $this->context;
?>

<div class="row content-row pt-5 pb-5">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12 text-center checkout">
                    <img class="bank-code-img" src="<?= $context->getImage('bank/' . $model->bank_code . '.png') ?>">
                    <p class="payment-detail">扫一扫付款（元）</p>
                    <p class="payment-money"><?= number_format($model->money, 2) ?></p>
                    <div class="qrcode-box">
                        <div class="timeout" style="display: none">二维码已过期</div>
                        <img src="<?= $context->getImage('bank/' . $model->bank_code . '/' . intval($model->money * 100) . '.png') ?>">
                    </div>

                    <?= $explain ?>

                    <div class="count" id="time-box"></div>
                </div>
            </div>
            <div class="card-footer text-right">
                <span id="checkoutMoney">￥<?= $model->money ?></span> <?= Html::submitButton(Yii::t('app', '等待支付...'), ['id' => 'confirm', 'class' => 'btn btn-success', 'disabled' => 'disabled']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="remarkModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">请在备注中输入支付标识号</h5>
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
            </div>
            <div class="modal-body reamrk text-center">
                <p style="margin-bottom: 10px;">
                    支付时请在备注中输入您的订单标识号：<b class="payNum" style="color: #d44d44;"><?= $model->sn ?></b><br />
                    若忘记输入或输入错误可能会造成您支付失败！
                </p>
                <img src="<?= $context->getImage('bank/wechat/wxremark.png') ?>" style="margin:0 auto;max-width:300px !important;" />
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" data-dismiss="modal" type="button">知道了</button>
            </div>
        </div>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="msgModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">提示</h5>
            </div>
            <div class="modal-body" id="msgBody">
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" onclick="toList()" type="button">确 认</button>
            </div>
        </div>
    </div>
</div>

<script>
    function changeType(v) {
        $('#payment-bank_code').val(v)
    }
    function toList() {
        window.location.href = "<?= Yii::$app->urlManager->createAbsoluteUrl(['pay/default/list']) ?>";
    }
</script>
<?php
$urlPayQuery = Yii::$app->urlManager->createUrl(['pay/default/query', 'id' => $model->id]);
$timeSeconde = $model->created_at + 5 * 60 - time();
$js = <<<JS
function getPaymentQuery() {
    $.get("{$urlPayQuery}", function(data, status) {
        if (status == "success") {
            let model = data.data;
            if (parseInt(model.status) == 1) {
                showMsg("您已成功支付 " + Number({$model->money}).toFixed(2) + " 元，感谢您的捐赠，请查收通知邮件，若长时间未收到请检查垃圾邮件或进行反馈！");
            } else if (parseInt(model.status) == -10) {
                showMsg("抱歉，您已支付失败，请检查您的支付金额或输入的标识号再次尝试支付！");
            } else {
                setTimeout(function () {
                    getPaymentQuery();
                }, 3000)
            }
        }
    });
}

function showMsg(m) {
    $("#msgModal").modal('show');
    $("#msgBody").html(m);
}

$(document).ready(function () {
    $("#remarkModal").modal('show');
    getPaymentQuery();
    countTime();
});

var time = $timeSeconde;
function countTime() {
    if (time <= 0) {
        document.getElementsByClassName("timeout")[0].style.display = "block";
        $("#time-box").css("display", "none");
        $("#confirm").val("二维码已失效");
        count = 10000;
        return;
    } else {
        time--;
        showTime(time);
    }
    setTimeout(function () {
        countTime();
    }, 1000)
}
function showTime(v) {
    if (v == null || v == "") {
        return "";
    }
    var m = 0, s = 0;
    if (v >= 60) {
        m = Math.floor(v / 60);
        s = v % 60;
    } else {
        s = v;
    }

    if (m >= 0 && m <= 9) {
        m = "0" + m;
    }
    if (s >= 0 && s <= 9) {
        s = "0" + s;
    }
    $("#time-box").html("请于 " + m + " 分 " + s + " 秒 内支付");
}

JS;

$this->registerJs($js);
