<?php
use yii\widgets\ActiveForm;
use common\helpers\Html;

$this->title = Yii::t('app', 'Change Password');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row mt-3 user-menu">
    <div class="col-md-3">
        <?= $this->render('_nav') ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title"><?= $this->title ?></h5></div>
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
