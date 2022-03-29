<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Recharge as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\Recharge */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Recharge');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recharges'), 'url' => ['index']];
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
                    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'store_id')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'sn')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'payment_method')->textInput() ?>
                    <?= $form->field($model, 'payment_status')->textInput() ?>
                    <?= $form->field($model, 'paid_at')->textInput() ?>
                    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'tax')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'type')->textInput() ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'status')->textInput() ?>
                    <?= $form->field($model, 'created_at')->textInput() ?>
                    <?= $form->field($model, 'updated_at')->textInput() ?>
                    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="card-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>