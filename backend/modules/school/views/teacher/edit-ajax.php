<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\school\Teacher as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\school\Teacher */
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
        <?= $this->context->isAdmin() ? $form->field($model, 'store_id')->dropDownList($this->context->getStoresIdName()) : '' ?>
        <?= $form->field($model, 'parent_id')->dropDownList(ActiveModel::getTreeIdLabel()) ?>
        <?= $form->field($model, 'user_id')->dropDownList($this->context->getUsersIdName()) // $form->field($model, 'user_id')->widget(kartik\select2\Select2::classname(), ['data' => $this->context->getUsersIdName('email'), 'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => false],]) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'is_default')->radioList(YesNo::getLabels()) ?>
        <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
        <?= $form->field($model, 'sort')->textInput() ?>
        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
