<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Log as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\Log */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
                        'options' => ['class' => 'form-group row'],
                    ],
                ]); ?>
                <div class="col-sm-12">
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
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                        <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
