<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\pay\Payment as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\pay\Payment */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'FunPay收银台 收款方: Funson');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .timeout {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        background: rgba(255,255,255,.95);
        color: #222;
        line-height: 200px;
        text-align: center;
        z-index: 1;
    }
</style>

<section class="content-header">
    &nbsp;
</section>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <div class="col-sm-12 text-center">
                    <div class="timeout" style="display: block;">二维码已过期</div>
                    <img src="/resources/pay/bank/<?= $model->bank_code ?>/<?= intval($model->money) ?>.jpg">
                </div>
            </div>
            <div class="card-footer text-right">
                <span>￥<?= $model->money ?></span> <?= Html::submitButton(Yii::t('app', '等待支付...'), ['class' => 'btn btn-success', 'disabled' => 'disabled']) ?>
            </div>
        </div>
    </div>
</div>
<script>
    function changeType(v) {
        $('#payment-bank_code').val(v)
    }
</script>
<?php
$js = <<<JS
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
    } alert($('#payment-money').val());
});

JS;

$this->registerJs($js);
