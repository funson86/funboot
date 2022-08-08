<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\base\Role as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\base\Role */
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
        <h4 class="modal-title"><?= Yii::t('app', 'Data Permission') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <div class="col-md-12">
            <?= \common\widgets\jstree\JsTree::widget([
                'name' => "modelTree",
                'defaultData' => $departments,
                'selectIds' => $selectIds,
            ]) ?>
        </div>
        <input type="hidden" id="treeIds" name="tree_ids">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" onclick="submitForm()"><?= Yii::t('app', 'Save') ?></button>
    </div>
<?php ActiveForm::end(); ?>

<script>
    function submitForm() {
        var modelTreeIds = getCheckTreeIds("modelTree");
        $('#treeIds').val(modelTreeIds.join(','));
        return true;
    }
</script>