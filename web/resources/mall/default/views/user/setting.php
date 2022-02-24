<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user \common\models\User */
/* @var $model \common\models\forms\ChangePasswordForm */

$this->title = Yii::t('app', 'Setting');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-section">
    <div class="container">
        <div class="row page-center">
            <div class="col-md-12 p-0">
                <div class="card message-send-view">
                    <div class="card-header">
                        <?= $this->render('_nav', ['type' => 'setting']) ?>
                    </div>

                    <div class="card-body pt-5">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 pb-5">
                                <?php $form = ActiveForm::begin(); ?>
                                <div class="card message-send-view">
                                    <div class="card-header text-center"><?= Yii::t('app', 'Profile') ?></div>

                                    <div class="card-body">
                                        <?= $form->field($user, 'email', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>

                                        <?= $form->field($user, 'name', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>

                                        <?= $form->field($user, 'mobile', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>
                                    </div>
                                    <div class="card-footer">
                                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-info control-full']) ?>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>

                            <div class="col-md-6 col-sm-12 pb-5">
                                <?php $form = ActiveForm::begin(); ?>
                                <div class="card message-send-view">
                                    <div class="card-header text-center"><?= Yii::t('app', 'Change Password') ?></div>

                                    <div class="card-body">
                                        <?= $form->field($model, 'oldpassword', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>

                                        <?= $form->field($model, 'password', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->passwordInput(['placeholder' => Yii::t('app', ' ')]) ?>

                                        <?= $form->field($model, 'repassword', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->passwordInput(['placeholder' => Yii::t('app', ' ')]) ?>
                                    </div>
                                    <div class="card-footer">
                                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary control-full']) ?>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
