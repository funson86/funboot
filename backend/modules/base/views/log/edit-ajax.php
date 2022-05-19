<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Log as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\base\Log */
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
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'method')->dropDownList(ActiveModel::getMethodLabels()) ?>
        <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'user_agent')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'agent_type')->dropDownList(ActiveModel::getAgentTypeLabels()) ?>
        <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'ip_info')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'code')->textInput() ?>
        <?= $form->field($model, 'msg')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'cost_time')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
