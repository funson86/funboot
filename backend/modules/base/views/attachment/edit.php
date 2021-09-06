<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Attachment as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\Attachment */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Attachment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attachments'), 'url' => ['index']];
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
                    <?= $form->field($model, 'upload_type')->dropDownList(ActiveModel::getUploadTypeLabels()) ?>
                    <?= $form->field($model, 'file_type')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'ext')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'year')->textInput() ?>
                    <?= $form->field($model, 'month')->textInput() ?>
                    <?= $form->field($model, 'day')->textInput() ?>
                    <?= $form->field($model, 'width')->textInput() ?>
                    <?= $form->field($model, 'height')->textInput() ?>
                    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
                    <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
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
