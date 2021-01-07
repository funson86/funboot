<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\MessageType as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\base\Message */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['edit-ajax', 'id' => $model['id']]),
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
    ],
]);
?>
    <div class="modal-header">
        <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'send_type')->checkboxList(ActiveModel::getSendTypeLabels()) ?>
        <?= $form->field($model, 'send_target')->radioList(ActiveModel::getSendTargetLabels()) ?>
        <?= $form->field($model, 'sendUsers')->widget(kartik\select2\Select2::classname(), [
            'data' => $allUsers,
            'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
        ]) ?>
        <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
        <?= $form->field($model, 'sort')->textInput() ?>
        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>

<script>
$(function () {
    $('#message-send_target input').change(function () {
        let value = $('#message-send_target input:checked').val();
        if (value == 1) {
            $('.field-message-sendusers').hide();
        } else {
            $('.field-message-sendusers').show();
        }
    })

    let value = $('#message-send_target input:checked').val();
    if (value == 1) {
        $('.field-message-sendusers').hide();
    }
});
</script>
