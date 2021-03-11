<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\cms\Page as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\cms\Page */
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
        <?= $form->field($model, 'catalog_id')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'banner')->widget(\common\components\uploader\FileWidget::class, [
                    'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                    'theme' => 'default',
                    'themeConfig' => [],
                    'config' => [
                        // 可设置自己的上传地址, 不设置则默认地址
                        // 'server' => '',
                        'pick' => [
                            'multiple' => false,
                        ],
                    ]
                ]); ?>
        <?= $form->field($model, 'banner_h5')->widget(\common\components\uploader\FileWidget::class, [
                    'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                    'theme' => 'default',
                    'themeConfig' => [],
                    'config' => [
                        // 可设置自己的上传地址, 不设置则默认地址
                        // 'server' => '',
                        'pick' => [
                            'multiple' => false,
                        ],
                    ]
                ]); ?>
        <?= $form->field($model, 'images')->widget(\common\components\uploader\FileWidget::class, [
                    'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                    'theme' => 'default',
                    'themeConfig' => [],
                    'config' => [
                        // 可设置自己的上传地址, 不设置则默认地址
                        // 'server' => '',
                        'pick' => [
                            'multiple' => true,
                        ],
                    ]
                ]); ?>
        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'seo_description')->textarea() ?>
        <?= $form->field($model, 'brief')->textarea() ?>
        <?= $form->field($model, 'content')->widget(\common\components\ueditor\Ueditor::class, []) ?>
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'redirect_url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'template')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'click')->textInput() ?>
        <?= $form->field($model, 'para1')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'para2')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'para3')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'para4')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'para5')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'para6')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'para7')->textInput() ?>
        <?= $form->field($model, 'para8')->textInput() ?>
        <?= $form->field($model, 'para9')->textInput() ?>
        <?= $form->field($model, 'para10')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
        <?= $form->field($model, 'sort')->textInput() ?>
        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
