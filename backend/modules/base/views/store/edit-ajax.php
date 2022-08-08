<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\Store as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\Store */
/* @var $user common\models\User */
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
        <?= $form->field($model, 'brief')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'host_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'expiredTime')->widget(kartik\date\DatePicker::class, [
            'language' => 'zh-CN',
            'layout'=>'{picker}{input}',
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true, // 今日高亮
                'autoclose' => true, // 选择后自动关闭
                'todayBtn' => true, // 今日按钮显示
            ],
            'options'=>[
                'class' => 'form-control no_bor',
            ]
        ]) ?>
        <?= $form->field($model, 'route')->dropDownList(ActiveModel::getRouteLabels()) ?>
        <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($user, 'password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'langBackends')->checkboxList(ActiveModel::getLanguageLabels()) ?>
        <?= $form->field($model, 'lang_backend_default')->dropDownList(ActiveModel::getLanguageCodeLabels(), ['prompt' => Yii::t('app', 'Please Select')]) ?>
        <?= $form->field($model, 'langFrontends')->checkboxList(ActiveModel::getLanguageLabels()) ?>
        <?= $form->field($model, 'lang_frontend_default')->dropDownList(ActiveModel::getLanguageCodeLabels(), ['prompt' => Yii::t('app', 'Please Select')]) ?>
        <?= $form->field($model, 'langApis')->checkboxList(ActiveModel::getLanguageLabels()) ?>
        <?= $form->field($model, 'lang_api_default')->dropDownList(ActiveModel::getLanguageCodeLabels(), ['prompt' => Yii::t('app', 'Please Select')]) ?>
        <?= $form->field($model, 'types')->checkboxList(ActiveModel::getTypeLabels()) ?>
        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels(null, true)) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
