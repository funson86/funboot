<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="page-section section-login">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 login-part-form">
                <div class="login-part-text-inner">
                    <h3>Welcome Back ! <br>
                        Please Sign in now</h3>
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <?= $form->field($model, 'email', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>
                        <?= $form->field($model, 'password', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->passwordInput(['placeholder' => Yii::t('app', ' ')]) ?>
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <div class="col-md-12 form-group">
                            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn-3', 'name' => 'login-button']) ?>

                            <?= Html::a(Yii::t('app', 'Forgot Password?'), ['/mall/default/request-password-reset'], ['class' => 'lost_pass']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="login-part-text text-center">
                    <div class="login-part-text-inner">
                        <h2>New to our Shop?</h2>
                        <p>There are advances being made in science and technology
                            everyday, and a good example of this is the online shop.</p>
                        <?= Html::a(Yii::t('app', 'Sign up'), ['/mall/default/signup'], ['class' =>'btn-3']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
