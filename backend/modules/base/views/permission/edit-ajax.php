<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\base\Permission as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\base\Permission */
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
    <style>
        .fade:not(.show) {
            opacity: 1 !important;
        }
    </style>
    <div class="modal-header">
        <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <?= $form->field($model, 'parent_id')->dropDownList(ActiveModel::getTreeIdLabel(0, true, Yii::t('app', 'Root Menu'))) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'brief')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'icon')->widget(\common\widgets\iconpicker\IconPicker::className(), []) ?>
        <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'target')->radioList(ActiveModel::getTargetLabels()) ?>
        <?= $form->field($model, 'sort')->textInput() ?>
        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
