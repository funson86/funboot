<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\SettingType as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\base\SettingType */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['edit-ajax', 'id' => $model['id']]),
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
    ],
]);
?>
    <div class="modal-header">
        <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <?= $form->field($model, 'parent_id')->dropDownList(ActiveModel::getTreeIdLabel()) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'brief')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
        <?= $form->field($model, 'value_range')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'value_default')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'supportRoles')->checkboxList(ActiveModel::getSupportRoleLabels()) ?>
        <?= $form->field($model, 'support_system')->dropDownList(ActiveModel::getSupportSystemLabels()) ?>
        <?= $form->field($model, 'grade')->dropDownList(ActiveModel::getGradeLabels()) ?>
        <?= $form->field($model, 'sort')->textInput() ?>
        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
