<?php
use yii\widgets\ActiveForm;
use common\helpers\Html;

$this->title = Yii::t('app', 'Profile');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row mt-3 user-menu">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title"><?= $this->title ?></h5></div>
            <div class="card-body">
                <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

            </div>
            <div class="card-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
