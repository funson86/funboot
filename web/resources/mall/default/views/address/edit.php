<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\helpers\CommonHelper;

/* @var $this yii\web\View */
$this->title = (Yii::$app->request->get('id') ? Yii::t('app', 'Update ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Address') ;
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([]);
?>

<div class="page-section">
    <div class="row page-center ">
        <div class="col-md-offset-3 col-md-6">
            <div class="card message-send-view">
                <div class="card-header text-center">
                    <?= Html::encode($this->title) ?>
                </div>

                <div class="card-body">

                    <?= $form->field($model, 'first_name', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>
                    <?= $form->field($model, 'last_name', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>
                    <?= $form->field($model, 'address', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                    <?= $form->field($model, 'address2', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                    <?= $form->field($model, 'city', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                    <?= $form->field($model, 'province', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                    <?= $form->field($model, 'country', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                    <?= $form->field($model, 'mobile', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>
                    <?= $form->field($model, 'postcode', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary control-full px-5']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script>
    $('#address-mobile').keyup(function () {
        $(this).val($(this).val().replace(/\s/g, ''))
    })
</script>
