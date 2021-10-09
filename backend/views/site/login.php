<?php
use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;
use common\helpers\ImageHelper;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$store = $this->context->store;
?>

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body card-shadow">
            <div class="login-logo">
                <img src="<?= $store->settings['website_logo'] ?: ImageHelper::getLogo() ?>" width="100" height="100" style="border-radius: 50%" />
            </div>
            <div class="login-logo" id="login-name">
                <a href="#"><?= $store->settings['website_name'] ?: 'Funboot' ?></a>
            </div>
            <!--p class="login-box-msg"><?= Yii::t('app', 'Sign in to start your session') ?></p-->

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form
                ->field($model,'username', [
                    'options' => ['class' => 'form-group has-feedback'],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group mb-3']
                ])
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

            <?= $form
                ->field($model, 'password', [
                    'options' => ['class' => 'form-group has-feedback'],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group mb-3']
                ])
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

            <?php if ($model->scenario == 'captchaRequired') { ?>
            <?= $form->field($model,'verifyCode')->widget(Captcha::class, [
                'template' => '<div class="row mx-1"><div class="col-xs-7">{input}</div><div class="col-xs-5">{image}</div></div>',
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

            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <?= Html::submitButton(Yii::t('app', 'Sign in'), ['class' => 'btn btn-primary btn-block']) ?>
                </div>
                <!-- /.col -->
            </div>


            <?php ActiveForm::end(); ?>

            <!--div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                    using Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                    in using Google+</a>
            </div-->
            <!-- /.social-auth-links -->

            <!--a href="#">I forgot my password</a><br>
            <a href="register.html" class="text-center">Register a new membership</a-->

        </div>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->

<script>
    $(document).ready(function () {
        if (window.location.host == 'www.funboot.net') {
            $('#login-name').after('<p class="text-center">演示帐号：test 密码：123456</p>');
        }
    });

</script>
