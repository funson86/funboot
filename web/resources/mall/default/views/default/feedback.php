<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\helpers\MallHelper;
use common\helpers\ArrayHelper;

$store = $this->context->store;

$this->title = Yii::t('app', 'Feedback');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                <div class="card message-send-view">
                    <div class="card-header">
                        <?= Html::encode($this->title) ?>
                    </div>

                    <div class="card-body">

                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'name', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>
                        <?= $form->field($model, 'mobile', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                        <?= $form->field($model, 'email', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                        <?= $form->field($model, 'content')->textarea(['rows' => 4, 'class' => 'form-control ', 'placeholder' => Yii::t('app', 'Content')])->label(false) ?>

                        <?php if ($model->scenario == 'captchaRequired') { ?>
                            <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::class, [
                                'captchaAction' => '/mall/default/captcha',
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

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'feedback-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
