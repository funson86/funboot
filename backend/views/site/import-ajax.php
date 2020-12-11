<?php
/*
 * 通用上传弹出框
 */
use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\Url;

$form = ActiveForm::begin([
    'id' => 'import',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['import-ajax']),
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
    ]
]);
?>
    <div class="modal-header">
        <h4 class="modal-title">导入</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <?= Html::label(Yii::t('app', '导入文件'), 'importFile', ['class' => 'col-lg-4 control-label']) ?>
            <div class="col-lg-8"><?= Html::fileInput('importFile') ?></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>

