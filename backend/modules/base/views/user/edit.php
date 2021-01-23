<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\User as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'username')->textInput(['disabled' => 'disabled', 'maxlength' => true]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'birthday')->widget(\kartik\date\DatePicker::className(), [
                        'language' => 'zh-CN',
                        'layout' => '{picker}{input}',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,// 今日高亮
                            'autoclose' => true,// 选择后自动关闭
                            'todayBtn' => true,// 今日按钮显示
                        ],
                        'options' => [
                            'class' => 'form-control no_bor',
                        ]
                    ]); ?>
                    <?= $form->field($model, 'sex')->radioList(ActiveModel::getSexLabels()) ?>
                    <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels(null, true)) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'roles')->widget(kartik\select2\Select2::classname(), [
                        'data' => $allRoles,
                        'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
                    ]) ?>
                    <?= $form->field($model, 'avatar')->widget(\common\components\uploader\FileWidget::className(),[
                        'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                        'config' => [
                            'pick' => [
                                'multiple' => false,
                            ]
                        ]
                    ]) ?>
                    <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'remark')->textarea() ?>
                    <?= $form->field($model, 'access_token')->widget(\common\components\ueditor\Ueditor::class, [
                        // 'server' => '', // 图片上传路径 + 驱动
                    ]); ?>
                </div>
            </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Submit') ?></button>
                <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
