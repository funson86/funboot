<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Attachment as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\base\Attachment */
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
        <?= $form->field($model, 'upload_type')->dropDownList(ActiveModel::getUploadTypeLabels()) ?>
        <?= $form->field($model, 'file_type')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'ext')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'year')->textInput() ?>
        <?= $form->field($model, 'month')->textInput() ?>
        <?= $form->field($model, 'day')->textInput() ?>
        <?= $form->field($model, 'width')->textInput() ?>
        <?= $form->field($model, 'height')->textInput() ?>
        <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
