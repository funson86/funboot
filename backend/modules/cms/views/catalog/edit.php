<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\cms\Catalog as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Catalog */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-1" data-toggle="pill" href="#tab-content-1"><?= Yii::t('app', 'Basic info') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-2" data-toggle="pill" href="#tab-content-2"><?= Yii::t('app', 'Advanced') ?></a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-content-1">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'is_nav')->radioList(YesNo::getLabels()) ?>
                        <?= $form->field($model, 'redirect_url')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
                        <?= $form->field($model, 'template')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'template_page')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'sort')->textInput() ?>
                        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                    </div>
                    <div class="tab-pane fade" id="tab-content-2">
                        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_description')->textarea() ?>
                        <?= $form->field($model, 'banner')->widget(\common\components\uploader\FileWidget::class, [
                            'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                            'theme' => 'default',
                            'themeConfig' => [],
                            'config' => [
                                // 可设置自己的上传地址, 不设置则默认地址
                                // 'server' => '',
                                'pick' => [
                                    'multiple' => true,
                                ],
                            ]
                        ]); ?>
                        <?= $form->field($model, 'banner_h5')->widget(\common\components\uploader\FileWidget::class, [
                            'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                            'theme' => 'default',
                            'themeConfig' => [],
                            'config' => [
                                // 可设置自己的上传地址, 不设置则默认地址
                                // 'server' => '',
                                'pick' => [
                                    'multiple' => true,
                                ],
                            ]
                        ]); ?>
                        <?= $form->field($model, 'content')->widget(\common\components\ueditor\Ueditor::class, []) ?>
                    </div>
                </div>
                <div class="card-footer">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                    <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
                </div>
            </div>
            <!-- /.card -->
        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>