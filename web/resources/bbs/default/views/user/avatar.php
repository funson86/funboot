<?php
use yii\widgets\ActiveForm;
use common\helpers\Html;

$this->title = Yii::t('app', 'Avatar');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'avatar',
    'options'     => ['enctype' => 'multipart/form-data'],
]); ?>
<div class="row mt-3 user-menu">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title"><?= $this->title ?></h5></div>
            <div class="card-body">
                <?= Html::img($model->getMixedAvatar(200), ['width' => 200, 'height' => 200]); ?>
                <?= Html::img($model->getMixedAvatar(50), ['width' => 50, 'height' => 50]); ?>
                <?= Html::img($model->getMixedAvatar(24), ['width' => 24, 'height' => 24]); ?>

                <br><br>

                <?= $form->field($model, 'avatar')->fileInput(); ?>
            </div>
            <div class="card-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
