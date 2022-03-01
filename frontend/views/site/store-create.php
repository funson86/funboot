<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\helpers\MallHelper;
use common\helpers\ArrayHelper;

$store = $this->context->store;

$this->title = Yii::t('app', 'Store Create');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .help-block-error {
        width: 100%;
    }
</style>
<div class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                <?= $form->field($model, 'password', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->passwordInput(['placeholder' => Yii::t('app', ' ')]) ?>
                <?= $form
                    ->field($model,'code', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '<div class="input-group-prepend"><div class="input-group-text">https://</div></div>{input}<div class="input-group-append"><div class="input-group-text">.funboot.com</div></div>',
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'wrapperOptions' => ['class' => 'input-group mb-3']
                    ])
                    ->label(Yii::t('app', 'url'))
                    ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

                <?php if ($model->scenario == 'captchaRequired') { ?>
                    <?= $form->field($model,'verifyCode')->widget(\yii\captcha\Captcha::class, [
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
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'store-create-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
