<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Stuff as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\Stuff */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Stuff');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stuffs'), 'url' => ['index']];
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
                    <?= $form->field($model, 'code')->widget(kartik\select2\Select2::classname(), [
                        'data' => $model->mapCode,
                        'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
                    ]) ?>
                    <?= $form->field($model, 'brief')->textInput(['maxlength' => true]) ?>
                    <?php if (Yii::$app->request->get('type', ActiveModel::TYPE_TEXT) == ActiveModel::TYPE_TEXT) { ?>
                    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>
                    <?php } else { ?>
                    <?= $form->field($model, 'content')->widget(\common\components\uploader\FileWidget::class, [
                        'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                        'theme' => 'default',
                        'themeConfig' => [],
                        'config' => [
                            // 可设置自己的上传地址, 不设置则默认地址
                            // 'server' => '',
                            'pick' => [
                                'multiple' => false,
                            ],
                        ]
                    ]); ?>
                    <?php } ?>
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'position')->dropDownList(ActiveModel::getPositionLabels()) ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
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