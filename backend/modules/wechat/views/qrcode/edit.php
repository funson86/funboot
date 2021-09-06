<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\wechat\Qrcode as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\wechat\Qrcode */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Qrcode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Qrcodes'), 'url' => ['index']];
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
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'scene_id')->textInput() ?>
                    <?= $form->field($model, 'scene_str')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'expired_second')->textInput() ?>
                    <?= $form->field($model, 'subscribe_count')->textInput() ?>
                    <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
                    <?= $form->field($model, 'status')->textInput() ?>
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