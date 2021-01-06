<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\helpers\MallHelper;
use common\helpers\ArrayHelper;

$store = $this->context->store;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'name')->textInput(['class' => 'form-control ', 'placeholder' => Yii::t('app', 'Name')])->label(false) ?>
                <?= $form->field($model, 'mobile')->textInput(['class' => 'form-control ', 'placeholder' => Yii::t('app', 'Mobile')])->label(false) ?>
                <?= $form->field($model, 'email')->textInput(['class' => 'form-control ', 'placeholder' => Yii::t('app', 'Email')])->label(false) ?>
                <?= $form->field($model, 'content')->textarea(['class' => 'form-control ', 'placeholder' => Yii::t('app', 'Content')])->label(false) ?>

                <?php if ($model->scenario == 'captchaRequired') { ?>
                    <?= $form->field($model,'verifyCode')->widget(\yii\captcha\Captcha::class, [
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

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'feedback-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
if (!$resultMsg) return;

$this->registerCssFile('@web/resources/toastr/toastr.min.css');
$this->registerJsFile("@web/resources/toastr/toastr.min.js");

echo "<style>.toast-top-center {top: 200px;}</style>";
$js = <<<JS
toastr.options = {
    "closeButton": true, //是否显示关闭按钮
    "positionClass": "toast-top-center",//弹出窗的位置
    "timeOut": "59000", //展现时间
};
$(document).ready(function () {
    toastr.success("{$resultMsg}");
    setTimeout(function() {
        window.location.href = '/';
    }, 5000);
});
JS;
$this->registerJs($js);
