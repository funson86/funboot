<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\PointLog as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\PointLog */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Point Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Point Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <div class="col-sm-12">
                    <?= $this->context->isAdmin() ? $form->field($model, 'store_id')->dropDownList($this->context->getStoresIdName()) : '' ?>
                    <?= $form->field($model, 'user_id')->dropDownList($this->context->getUsersIdName()) // $form->field($model, 'user_id')->widget(kartik\select2\Select2::classname(), ['data' => $this->context->getUsersIdName('email'), 'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => false],]) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'change')->textInput() ?>
                    <?= $form->field($model, 'original')->textInput() ?>
                    <?= $form->field($model, 'balance')->textInput() ?>
                    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                </div>
            </div>
            <div class="card-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                <span class="btn btn-default" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
