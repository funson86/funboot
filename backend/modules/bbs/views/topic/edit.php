<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\bbs\Topic as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\bbs\Topic */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Topic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Topics'), 'url' => ['index']];
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
        <div class="card">
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
                        <?= $form->field($model, 'node_id')->dropDownList(\common\models\bbs\Node::getTreeIdLabel(0, false)) ?>
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?php if ($model->format == ActiveModel::FORMAT_MARKDOWN) { ?>
                        <?= $form->field($model, 'content')->widget(\common\widgets\markdown\Markdown::class, []) ?>
                        <?php } else { ?>
                        <?= $form->field($model, 'content')->widget(\common\components\ueditor\Ueditor::class, []) ?>
                        <?php } ?>
                        <?= $form->field($model, 'template')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'is_comment')->radioList(YesNo::getLabels()) ?>
                        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                    </div>
                    <div class="tab-pane fade" id="tab-content-2">
                        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>
                        <?= $form->field($model, 'thumb')->widget(\common\components\uploader\FileWidget::class, [
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
                        <?= $form->field($model, 'images')->widget(\common\components\uploader\FileWidget::class, [
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
                        <?= $form->field($model, 'brief')->textarea(['rows' => 6]) ?>
                        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'redirect_url')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'click')->textInput() ?>
                        <?= $form->field($model, 'like')->textInput() ?>
                    </div>
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