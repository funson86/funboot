<?php
use yii\widgets\ActiveForm;
use common\helpers\Html;

$this->title = Yii::t('app', 'Modify Password');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-3 hidden-xs">&nbsp;</div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <?= $form->field($model, 'oldpassword')->passwordInput(['maxlength' => 255]) ?>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

                <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => 255]) ?>
            </div>
            <div class="card-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
