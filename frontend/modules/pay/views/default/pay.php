<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\pay\Payment as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\pay\Payment */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', '确认订单');
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 pay-label text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>

<style>
    .has-success .form-control {
        border-color: green;
    }
    .has-error .form-control {
        border-color: red;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        &nbsp;&nbsp;
    </section>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
            <div class="card">
                <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
                <div class="card-body">
                    <div class="col-sm-12">
                        <div class="order-info text-center">
                            <h1>订单提交成功，请填写捐赠信息</h1>
                            <p class="order-detail">为减轻后台压力，忘记支付的小同学将在次日9点统一收到支付结果邮件通知</p>
                            <p class="order-detail"></p>
                        </div>

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'kind')->dropDownList(ActiveModel::getKindLabels()) ?>
                        <?= $form->field($model, 'money')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'email_exp')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'bank_code')->hiddenInput(['maxlength' => true, 'value' => 'wechat'])->label(false) ?>

                        <?php if ($model->scenario == 'captchaRequired') { ?>
                            <?= $form->field($model,'verifyCode')->widget(\yii\captcha\Captcha::class, [
                                'captchaAction' => '/site/captcha',
                                'template' => '<div class="row"><div class="col-xs-7">{input}</div><div class="col-xs-5">{image}</div></div>',
                                'imageOptions' => [
                                    'alt' => Yii::t('app', 'Click to change'),
                                    'title' => Yii::t('app', 'Click to change'),
                                    'style' => 'cursor:pointer'
                                ],
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => Yii::t('app', 'Verification Code'),
                                ],
                            ])->label(false); ?>
                        <?php } ?>

                        <div class="pay-type">
                            <div class="pay-title">支付方式</div>
                            <div class="pay-items">
                                <div class="pay-item active" id="wechat" onclick="changeType('wechat')"><img alt="" src="/resources/pay/bank/wechat.png"></div>
                                <div class="pay-item " id="alipay" onclick="changeType('alipay')"><img alt="" src="/resources/pay/bank/alipay.png"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <?= Html::submitButton(Yii::t('app', '立即支付'), ['class' => 'btn btn-primary ']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function changeType(v) {
        $('#payment-bank_code').val(v)
        $('.pay-item').removeClass('active')
        $('#' + v).addClass('active')
    }
</script>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
if (document.body.clientWidth < 992) {
    $('.pay-label').removeClass('text-right');
}

$('.field-payment-money').hide();
$('#payment-money').val(parseFloat($('#payment-kind').val()));

$('#payment-kind').change(function() {
    var value = $('#payment-kind').val();
    if (parseInt(value) === -1) {
        $('#payment-money').val('');
        $('.field-payment-money').show();
    } else {
        $('#payment-money').val(parseFloat(value));
        $('.field-payment-money').hide();
    }
});

JS;

$this->registerJs($js);


if ($resultMsg) {
    $this->registerCssFile('@web/resources/toastr/toastr.min.css');
    $this->registerJsFile("@web/resources/toastr/toastr.min.js");

    echo "<style>.toast-top-center {top: 200px;}</style>";
    $js = <<<JS
toastr.options = {
    "closeButton": true, //是否显示关闭按钮
    "positionClass": "toast-top-center",//弹出窗的位置
    "timeOut": "10000", //展现时间
};
$(document).ready(function () {
    toastr.error("{$resultMsg}");
});
JS;
    $this->registerJs($js);

}
