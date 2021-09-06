<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\cms\Page as ActiveModel;
use common\models\base\Lang;
use common\helpers\Url;
use common\models\cms\Catalog;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Page */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$format = Yii::$app->request->get('format');
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        // 'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
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
                    <?php if ($this->context->isMultiLang) { ?>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-3" data-toggle="pill" href="#tab-content-lang"><?= Yii::t('app', 'Multi Language') ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-content-1">
                        <div class="row">
                            <?= !Yii::$app->request->get('id') ? Html::a(Yii::t('app', 'Choose Catalog'), ['edit-catalog'], ['class' => 'btn btn-sm btn-success mr-2']) : '' ?>
                            <?php
                                foreach (ActiveModel::getFormatLabels() as $code => $label) {
                                    echo Html::a($label, ['edit', 'id' => Yii::$app->request->get('id'), 'catalog_id' => Yii::$app->request->get('catalog_id'), 'format' => $code], ['class' => 'btn btn-sm btn-info mr-2']);
                                }
                            ?>
                        </div>

                        <?php if (Yii::$app->request->get('id') && $model->catalog->code != 'default') { ?>
                        <?= $form->field($model, 'catalog_id')->dropDownList(Catalog::getTreeIdLabel(0, false)) ?>
                        <?php } ?>

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                        <?php if ($model->catalog->code == 'default') { ?>
                        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                        <?php } ?>

                        <?= $form->field($model, 'brief')->textarea() ?>

                        <?php if ($format == ActiveModel::FORMAT_TEXTAREA || (!$format && $model->catalog->code == 'default') || $model->format == ActiveModel::FORMAT_TEXTAREA) { ?>
                        <?= $form->field($model, 'content')->textarea(['rows' => 12]) ?>
                        <?php } elseif ($format == ActiveModel::FORMAT_MARKDOWN || $model->format == ActiveModel::FORMAT_MARKDOWN) { ?>
                        <?= $form->field($model, 'content')->widget(\common\widgets\markdown\Markdown::class, []) ?>
                        <?php } else { ?>
                        <?= $form->field($model, 'content', ['options' => ['style' => 'display: block'], 'labelOptions' => ['class' => 'control-label control-label-full']])->widget(\common\components\ueditor\Ueditor::class, []) ?>
                        <?php } ?>

                        <?php if ($model->catalog->code != 'default') { ?>
                        <?= $form->field($model, 'redirect_url')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'template')->textInput(['maxlength' => true]) ?>
                        <!--<?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>-->
                        <?php if ($model->catalog->kind == Catalog::KIND_PRODUCT) { ?>
                        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                        <?php } ?>
                        <?php if ($model->catalog->kind == Catalog::KIND_NEWS) { ?>
                        <?= $form->field($model, 'click')->textInput() ?>
                        <?php } ?>
                        <?= $form->field($model, 'sort')->textInput() ?>
                        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="tab-content-2">
                        <?php if ($model->catalog->code != 'default') { ?>
                        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_description')->textarea() ?>
                        <?php } ?>
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
                        <?php if ($model->catalog->code != 'default') { ?>
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
                        <?php } ?>
                        <?= $form->field($model, 'param1')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'param2')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'param3')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'param4')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'param5')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'param6')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'param7')->textInput() ?>
                        <?= $form->field($model, 'param8')->textInput() ?>
                        <?= $form->field($model, 'param9')->textInput() ?>
                        <?= $form->field($model, 'param10')->textInput(['maxlength' => true]) ?>
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
                                                    if (ActiveModel::getLangFieldType($field) == 'textarea' || ($model->catalog->code == 'default' && ActiveModel::getLangFieldType($field) != 'text')) {
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