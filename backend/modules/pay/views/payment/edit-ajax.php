<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\pay\Payment as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\pay\Payment */
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
        <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'bank_code')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'money')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email_exp')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'sn')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->dropDownList(ActiveModel::getStatusLabels()) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
