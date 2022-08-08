<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\mall\AttributeItem as ActiveModel;
use common\models\base\Lang;

/* @var $this yii\web\View */
/* @var $model common\models\mall\AttributeItem */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Attribute Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attribute Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
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

                    <?php if ($this->context->isMultiLang) { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-lang" data-toggle="pill" href="#tab-content-lang"><?= Yii::t('app', 'Multi Language') ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-content-1">
                        <?= $form->field($model, 'attribute_id')->dropDownList(\common\models\mall\Attribute::getIdLabel()) ?>
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'brief')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'sort')->textInput() ?>
                        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                    </div>

                    <?php if ($this->context->isMultiLang) { ?>
                        <div class="tab-pane fade" id="tab-content-lang">
                            <?= $form->field($model, 'translating')->radioList(YesNo::getLabels())->hint(Yii::t('app', 'Auto translating while selecting yes and field is empty'), ['class' => 'ml-3']) ?>
                            <div class="row">
                                <div class="col-2 col-sm-2">
                                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                        <?php $i = 0; foreach ($lang as $field => $item) { ?>
                                            <a class="nav-link <?= $i == 0 ? 'active' : '' ?>" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-<?= $field ?>" role="tab" aria-controls="vert-tabs-home" aria-selected="true"><?= $model->getAttributeLabel($field) ?></a>
                                            <?php $i++; } ?>
                                    </div>
                                </div>
                                <div class="col-10 col-sm-10">
                                    <div class="tab-content" id="vert-tabs-tabContent">
                                        <?php $i = 0; foreach ($lang as $field => $item) { ?>
                                            <div class="tab-pane <?= $i == 0 ? 'active' : 'fade' ?>" id="vert-tabs-<?= $field ?>" role="tabpanel" aria-labelledby="vert-tabs-<?= $field ?>-tab">
                                                <?php foreach ($item as $language => $v) { ?>
                                                    <div class="form-group row field-catalog-redirect_url has-success">
                                                        <label class="control-label control-label-full"><?= Lang::getLanguageLabels(intval(Lang::getLanguageCode($language, false, true))) ?></label>
                                                        <?php
                                                        if (ActiveModel::getLangFieldType($field) == 'textarea') {
                                                            echo Html::textarea("Lang[$field][$language]", $v, ['class' => 'form-control', 'rows' => 6]);
                                                        } elseif (ActiveModel::getLangFieldType($field) == 'Ueditor') {
                                                            echo \common\components\ueditor\Ueditor::widget([
                                                                'id' => 'Ueditor-' . $field . '-' . $language,
                                                                'attribute' => $field,
                                                                'name' => 'Lang[' . $field . '][' . $language . ']',
                                                                'value' => $v,
                                                                'formData' => [
                                                                    'drive' => 'local',
                                                                    'writeTable' => false, // 不写表
                                                                ],
                                                                'config' => [
                                                                    'toolbars' => [
                                                                        [
                                                                            'fullscreen', 'source', 'undo', 'redo', '|',
                                                                            'customstyle', 'paragraph', 'fontfamily', 'fontsize'
                                                                        ],
                                                                        [
                                                                            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat',
                                                                            'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                                                                            'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                                                                            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                                                                            'directionalityltr', 'directionalityrtl', 'indent', '|'
                                                                        ],
                                                                        [
                                                                            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                                                                            'link', 'unlink', '|','simpleupload',
                                                                            'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'insertcode', 'pagebreak', '|',
                                                                            'horizontal', 'inserttable', '|',
                                                                            'print', 'preview', 'searchreplace', 'help'
                                                                        ]
                                                                    ],
                                                                ]
                                                            ]) ;
                                                        } elseif (ActiveModel::getLangFieldType($field) == 'markdown') {
                                                            echo \common\widgets\markdown\Markdown::widget([
                                                                'id' => 'markdown-' . $field . '-' . $language,
                                                                'attribute' => $field,
                                                                'name' => 'Lang[' . $field . '][' . $language . ']',
                                                                'value' => $v,
                                                                'options' => [
                                                                    'width' => "100%",
                                                                    'height' => 500,
                                                                    'emoji' => false,
                                                                    'taskList' => true,
                                                                    'flowChart' => true, // 流程图
                                                                    'sequenceDiagram' => true, // 序列图
                                                                    'tex' => true, // 科学公式
                                                                    'imageUpload' => true,
                                                                    'imageUploadURL' => Url::toRoute([
                                                                        '/file/image-markdown',
                                                                        'driver' => Yii::$app->params['uploaderConfig']['image']['driver'],
                                                                    ]),
                                                                ]
                                                            ]) ;
                                                        } else {
                                                            echo Html::textInput("Lang[$field][$language]", $v, ['class' => 'form-control']);
                                                        }

                                                        ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php $i++; } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="card-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                <span class="btn btn-default" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
