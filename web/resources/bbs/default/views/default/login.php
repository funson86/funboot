<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-page">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
            <div class="card mt-5 message-send-view">
                <div class="card-header">
                    <?= Html::encode($this->title) ?>
                </div>

                <div class="card-body">

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'email', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>

                        <?= $form->field($model, 'password', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->passwordInput(['placeholder' => Yii::t('app', ' ')]) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <div class="form-group flex-row-space">
                            <?= Html::a(Yii::t('app', 'Forgot Password?'), ['/bbs/default/request-password-reset']) ?>
                            <?= Html::a(Yii::t('app', 'Resend Verification Email?'), ['/bbs/default/resend-verification-email']) ?>
                        </div>

                        <div class="form-group text-center pt-3">
                            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary pl-5 pr-5', 'name' => 'login-button']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
