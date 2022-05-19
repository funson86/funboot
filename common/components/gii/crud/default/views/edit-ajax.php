<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use <?= ltrim($generator->modelClass, '\\') ?> as ActiveModel;


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
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
        <h4 class="modal-title"><?= "<?" ?>= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
<?php
if (!empty($generator->formFields)) {
    foreach ($generator->formFields as $attribute) {
        echo "        <?= " . $generator->generateActiveFieldFunboot($attribute, true) . " ?>\n";
    }
} else {
    foreach ($generator->getColumnNames() as $attribute) {
        if (in_array($attribute, ['id', 'created_at', 'updated_at', 'created_by', 'updated_by'])) {
            continue;
        }
        if (in_array($attribute, $safeAttributes)) {
            echo "        <?= " . $generator->generateActiveFieldFunboot($attribute, true) . " ?>\n";
        }
    }
}?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= "<?" ?>= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= "<?" ?>= Yii::t('app', 'Submit') ?></button>
    </div>
<?= "<?php " ?>ActiveForm::end(); ?>
