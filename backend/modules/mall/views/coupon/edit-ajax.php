<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\mall\Coupon as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\mall\Coupon */
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
        <?= $form->field($model, 'coupon_type_id')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'money')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'min_amount')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'started_at')->widget(kartik\date\DatePicker::class, [
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
        <?= $form->field($model, 'ended_at')->widget(kartik\date\DatePicker::class, [
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
        <?= $form->field($model, 'min_product_amount')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
