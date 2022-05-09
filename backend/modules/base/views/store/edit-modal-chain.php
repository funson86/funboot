<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\Store as ActiveModel;
use yii\helpers\ArrayHelper;

$data = ArrayHelper::map(Yii::$app->cacheSystem->getAllStore(), 'id', 'name');


/* @var $this yii\web\View */
/* @var $model common\models\Store */
/* @var $user common\models\User */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['edit-modal', 'id' => $model['id'], 'view' => 'edit-modal-renew']),
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
        <?= $form->field($model, 'chains')->widget(kartik\select2\Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
        ]) ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>
<?php ActiveForm::end(); ?>
