<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ModelSearch */

?>

<div class="modal fade" id="ajaxModalFilter" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <?php $form = ActiveForm::begin([
            'action' => [''],
            'method' => 'get',
            'enableClientScript' => false,
            'fieldConfig' => [
                'template' => "<div class='col-sm-4 text-sm-right'>{label}</div><div class='col-sm-8'>{input}\n{hint}\n{error}</div>",
            ],
        ]); ?>
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title"><?= Yii::t('app', 'Filter') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'id')->textInput(['value' => '']) ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'name')->textInput(['value' => '']) ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'status')->dropDownList($this->context->modelClass::getStatusLabels(null, true), ['prompt' => Yii::t('app', 'All'), 'value' => null]) ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'type')->dropDownList($this->context->modelClass::getTypeLabels(), ['prompt' => Yii::t('app', 'All'), 'value' => null]) ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
                <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                <?= Html::submitButton('<i class="fa fa-search"></i> ' . Yii::t('app', 'Search'), ['class' => 'btn btn-primary px-3']) ?>
            </div>

        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
