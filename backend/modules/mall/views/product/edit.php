<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\mall\Product as ActiveModel;
use common\helpers\Url;
use common\helpers\ImageHelper;
use common\models\base\Lang;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Product */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    #product-isattribute, #product-status, #product-content, #product-types {
        width: 100%;
    }
</style>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
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
                        <a class="nav-link" id="tab-2" data-toggle="pill" href="#tab-content-2"><?= Yii::t('app', 'Stock Attribute') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-3" data-toggle="pill" href="#tab-content-3"><?= Yii::t('app', 'Image Detail') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-4" data-toggle="pill" href="#tab-content-4"><?= Yii::t('app', 'Param') ?></a>
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
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <div class="row">
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'category_id')->dropDownList(\common\models\mall\Category::getTreeIdLabel(0, false)) ?></div>
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'brand_id')->dropDownList(\common\models\mall\Brand::getIdLabel(true)) ?></div>
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'vendor_id')->dropDownList(\common\models\mall\Vendor::getIdLabel(true)) ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'seo_url')->textInput(['maxlength' => true]) ?></div>
                            <div class="col-sm-8 pr-8">
                                <?= $form->field($model, 'tags')->widget(kartik\select2\Select2::class, [
                                    'data' => $allTags, //传入变量
                                    'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
                                ]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'sort')->textInput() ?></div>
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?></div>
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'volume')->textInput(['maxlength' => true]) ?></div>
                        </div>
                        <?= $form->field($model, 'types')->checkboxList(ActiveModel::getTypeLabels()) ?>
                        <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                    </div>

                    <div class="tab-pane fade show" id="tab-content-2">
                        <div class="row">
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'stock')->textInput() ?></div>
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'stock_warning')->textInput() ?></div>
                            <div class="col-sm-4 pr-4"><?= $form->field($model, 'stock_code')->textInput(['maxlength' => true]) ?></div>
                        </div>
                        <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'isAttribute')->radioList(YesNo::getLabelsNoYes()) ?>

                        <div class="row field-product-is-attribute-no">
                            <div class="col-sm-3 pr-3"><?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?> </div>
                            <div class="col-sm-3 pr-3"><?= $form->field($model, 'market_price')->textInput(['maxlength' => true]) ?> </div>
                            <div class="col-sm-3 pr-3"><?= $form->field($model, 'cost_price')->textInput(['maxlength' => true]) ?> </div>
                            <div class="col-sm-3 pr-3"><?= $form->field($model, 'wholesale_price')->textInput(['maxlength' => true]) ?> </div>
                        </div>
                        <div class="field-product-is-attribute-yes">
                            <?= $form->field($model, 'attribute_set_id')->dropDownList(\common\models\mall\AttributeSet::getIdLabel(true)) ?>

                            <dl class="control-group">
                                <dt><?= Yii::t('app', 'Attribute Value') ?></dt>
                                <dd>
                                    <table class="table table-product-attribute">
                                        <tbody>
                                        <?php foreach ($attributes as $attribute) { ?>
                                            <tr>
                                                <td><?= $attribute->name ?></td>
                                                <td id="attribute-<?= $attribute->id; ?>">
                                                    <?php foreach ($attribute->attributeItems as $attributeItem) { ?>
                                                        <span id="attribute-value-<?= $attributeItem['id']; ?>" data-type="<?= $attribute['type']; ?>" class="btn btn-default btn-sm btn-attribute" data-id="<?= $attributeItem['id']; ?>" data-name="<?= $attributeItem['name']; ?>" data-attribute-id="<?= $attribute->id; ?>" data-attribute-name="<?= $attribute->name; ?>" data-sort="<?= $attributeItem['sort']; ?>"><?= $attributeItem['name']; ?></span>

                                                        <?php if ($attribute['type'] == 2) { ?>
                                                            <span class="btn btn-sm selectColor" style="background:<?= strlen($mapProductAttributeItemAttributeItemIdLabel[$attributeItem['id']] ?? '') > 0 ? '#' . $mapProductAttributeItemAttributeItemIdLabel[$attributeItem['id']] : '#000000'; ?>;padding: 10px" data-href="<?= Url::to(['/site/color', 'value' => ($mapProductAttributeItemAttributeItemIdLabel[$attributeItem['id']] ?? '')])?>"></span>
                                                            <?= Html::hiddenInput('productAttributeItemLabels[' . $attributeItem['id'] .']', '#' . ($mapProductAttributeItemAttributeItemIdLabel[$attributeItem['id']] ?? ''))?>
                                                        <?php } elseif ($attribute['type'] == 3) { ?>
                                                            <img src="<?= $mapProductAttributeItemAttributeItemIdLabel[$attributeItem['id']] ?? ImageHelper::get('/resources/images/add-sku.png'); ?>" class="selectImage" href="<?= Url::to(['/file/index', 'boxId' => 'mall', 'upload_type' => 'image'])?>" data-toggle='modal' data-target='#ajaxModalMax'>
                                                            <?= Html::hiddenInput('productAttributeItemLabels[' . $attributeItem['id'] .']', $mapProductAttributeItemAttributeItemIdLabel[$attributeItem['id']] ?? '')?>
                                                        <?php } ?>

                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="hint-block">点击按钮进行属性值设置, 按钮选择的情况下颜色/图片选项属性值才会被保存</div>
                                </dd>
                            </dl>

                            <dl class="control-group block-product-sku hidden">
                                <dt><?= Yii::t('app', 'Product Sku') ?></dt>
                                <dd>
                                    <table class="table table-bordered table-product-sku table-hover">
                                        <thead></thead>
                                        <tbody></tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </dd>
                            </dl>

                        </div>

                    </div>
                    <div class="tab-pane fade show" id="tab-content-3">
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
                        <?= $form->field($model, 'image')->widget(\common\components\uploader\FileWidget::class, [
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
                        <?= $form->field($model, 'brief')->textarea(['rows' => 4]) ?>
                        <?= $form->field($model, 'content')->widget(\common\components\ueditor\Ueditor::class, []) ?>
                        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>
                    </div>

                    <div class="tab-pane fade show" id="tab-content-4">
                        <?= $form->field($model, 'param_id')->dropDownList(\common\models\mall\Param::getIdLabel(true, 'name', 'id', null, 0)) ?>
                        <dl class="control-group">
                            <!--dt><?= Yii::t('app', 'Param') ?></dt-->
                            <dd>
                                <table class="table table-param">
                                    <tbody>

                                    <?php if (isset($model->param_id) && isset($allParams[$model->param_id]->children)) { foreach ($allParams[$model->param_id]->children as $child2) { ?>
                                        <tr>
                                            <td align="center"><?= $child2->name ?></td>
                                            <td id="attribute-<?= $child2->id ?>"><?= Html::textInput('productParam[' . $child2->id . ']', $productParams[$child2->id] ?? '', ['class' => 'form-control'])?></td>
                                        </tr>
                                        <?php foreach ($child2->children as $child3) { ?>
                                        <tr>
                                            <td align="right"><?= $child3->name ?></td>
                                            <td id="attribute-<?= $child3->id ?>"><?= Html::textInput('productParam[' . $child3->id . ']', $productParams[$child3->id] ?? '', ['class' => 'form-control'])?></td>
                                        </tr>
                                        <?php } ?>
                                    <?php } } ?>
                                    </tbody>
                                </table>
                                <div class="hint-block">最多支持3级，如果有第3级，第2级一般做小分类可以不填写内容</div>
                            </dd>
                        </dl>

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
                <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<!-- 属性模板 -->
<script id="attributeTemplate" type="text/html">
    <tbody>
    {{each data as attribute i}}
    <tr>
        <td>{{attribute.name}}</td>
        <td>
            {{each attribute.attributeItems as item i}}
            <span id="option-{{item.id}}" data-type="{{attribute.type}}" class="btn btn-default btn-sm btn-attribute" data-id="{{item.id}}" data-name="{{item.name}}" data-attribute-id="{{attribute.id}}" data-attribute-name="{{attribute.name}}" data-sort="{{item.sort}}">{{item.name}}</span>
            {{if attribute.type == 2 }}
            <span class="btn btn-sm selectColor" style="background:#000000;padding: 10px" data-href="<?= Url::to(['/site/color'])?>"></span>
            <?= Html::hiddenInput('productAttributeItemLabels[{{item.id}}]', '')?>
            {{else if attribute.type == 3}}
            <img src="<?= ImageHelper::get('/resources/images/add-sku.png'); ?>" class="selectImage" href="<?= Url::to(['/file/index', 'boxId' => 'mall', 'upload_type' => 'image'])?>" data-toggle='modal' data-target='#ajaxModalMax'>
            <?= Html::hiddenInput('productAttributeItemLabels[{{item.id}}]', '')?>
            {{/if}}
            {{/each}}
        </td>
    </tr>
    {{/each}}
    </tbody>
</script>

<!-- 参数模板 -->
<script id="paramTemplate" type="text/html">
    <tbody>
    {{each data as item i}}
        <tr>
            <td align="center">{{item.name}}</td>
            <td>
                <?= Html::textInput('productParam[{{item.id}}]', '', ['class' => 'form-control'])?>
            </td>
        </tr>
        {{each item.children as item i}}
        <tr>
            <td align="right">{{item.name}}</td>
            <td>
                <?= Html::textInput('productParam[{{item.id}}]', '', ['class' => 'form-control'])?>
            </td>
        </tr>
        {{/each}}
    {{/each}}
    </tbody>
</script>

<!-- 表格头 -->
<script id="table-header" type="text/html">
    <tr>
        {{each attributes as value i}}
        <th>{{value}}</th>
        {{/each}}
        <th class="th-picture"><?= Yii::t('app', 'Sku Image') ?></th>
        <th class="th-sku"><?= Yii::t('app', 'Sku') ?></th>
        <th class="th-price"><?= Yii::t('app', 'Price') ?></th>
        <th class="th-price"><?= Yii::t('app', 'Market Price') ?></th>
        <th class="th-price"><?= Yii::t('app', 'Cost Price') ?></th>
        <th class="th-price"><?= Yii::t('app', 'Wholesale Price') ?></th>
        <th class="th-stock"><?= Yii::t('app', 'Stock') ?></th>
        <th class="th-status"><?= Yii::t('app', 'Status') ?></th>
    </tr>
</script>

<!-- 表格内容 -->
<script id="table-body" type="text/html">
    {{each data as value i}}
    <tr id="{{value.sku}}">
        {{each value.values as item j}}
        <td data-id="{{item.id}}">{{item.name}}</td>
        {{/each}}
        <td>
            <img src="" class="selectImage" href="<?= Url::to(['/file/index', 'boxId' => 'mall', 'upload_type' => 'image'])?>" data-toggle="modal" data-target="#ajaxModalMax">
            <input type="hidden" name="skus[{{value.sku}}][thumb]" class="js-thumb">
        </td>
        <td><input type="text" name="skus[{{value.sku}}][sku]" maxlength="10" class="js-skus-0 form-control" value="0"></td>
        <td><input type="text" name="skus[{{value.sku}}][price]" class="js-skus-1 form-control" maxlength="10" value="0"></td>
        <td><input type="text" name="skus[{{value.sku}}][market_price]" maxlength="10"  class="js-skus-2 form-control" value="0"></td>
        <td><input type="text" name="skus[{{value.sku}}][cost_price]" maxlength="10" class="js-skus-3 form-control" value="0"></td>
        <td><input type="text" name="skus[{{value.sku}}][wholesale_price]" maxlength="10" class="js-skus-4 form-control" value="0"></td>
        <td><input type="text" name="skus[{{value.sku}}][stock]" maxlength="10" class="js-skus-5 form-control" value="0"></td>
        <td>
            <select class="js-status form-control" name="skus[{{value.sku}}][status]" aria-invalid="false">
                <option value="0"><?= Yii::t('app', 'Inactive') ?></option>
                <option value="1" selected="selected"><?= Yii::t('app', 'Active') ?></option>
            </select>
        </td>
    </tr>
    {{/each}}
</script>

<!-- 表格底部 -->
<script id="table-footer" type="text/html">
    <tr>
        <td>
            <?= Yii::t('app', 'Batch Setting') ?>
        </td>
        <td colspan="{{colspan}}" style="text-align:left;">
            <div class="batch-opts">
                <span class="js-batch-type">
                    <a class="js-batch-sku blue" href="javascript:void (0);" onclick="batch(0)"><?= Yii::t('app', 'Sku') ?></a>
                    <a class="js-batch-price blue" href="javascript:void (0);" onclick="batch(1)"><?= Yii::t('app', 'Price') ?></a>
                    <a class="js-batch-market_price blue" href="javascript:void (0);" onclick="batch(2)"><?= Yii::t('app', 'Market Price') ?></a>
                    <a class="js-batch-cost_price blue" href="javascript:void (0);" onclick="batch(3)"><?= Yii::t('app', 'Cost Price') ?></a>
                    <a class="js-batch-wholesale_price blue" href="javascript:void (0);" onclick="batch(4)"><?= Yii::t('app', 'Wholesale Price') ?></a>
                    <a class="js-batch-stock blue" href="javascript:void (0);" onclick="batch(5)"><?= Yii::t('app', 'Stock') ?></a>
                </span>
                <span class="js-batch-form input-group hidden">
                    <input type="text" maxlength="11" class="js-batch-txt form-control input-sm" style="width:130px; flex: 0 1 auto">
                    <a class="js-batch-save btn btn-primary btn-sm m-l-xs" href="javascript:void (0);"><?= Yii::t('app', 'Save') ?></a>
                    <a class="js-batch-cancel btn btn-default btn-sm" href="javascript:void (0);"><?= Yii::t('app', 'Cancel') ?></a>
                </span>
            </div>
        </td>
    </tr>
</script>


<script>

    // 已经使用的属性值
    var enableValues = JSON.parse('<?= json_encode($enableValues); ?>');

    // 已经有数据的sku
    var productSkus = JSON.parse('<?= json_encode($productSkus); ?>');

    // 属性集下的属性数据
    var allAttribute = [];

    // 存储skus中的值，用来填充表格值
    var skusData = [];

    var addSkuThumb = "<?= ImageHelper::get('/resources/images/add-sku.png') ?>";

    var batchType = 0;

    $(function () {
        let isAttribute = $('#product-isattribute input:checked').val();
        if (parseInt(isAttribute) === 1) {
            $('.field-product-is-attribute-no').hide();
            $('.field-product-is-attribute-yes').show();

            // 将属性值变蓝
            for (let i = 0; i < enableValues.length; i++) {
                $("#attribute-value-" + enableValues[i]['id']).removeClass('btn-default');
                $("#attribute-value-" + enableValues[i]['id']).addClass('btn-primary');
                addAttribute(enableValues[i]['id'], enableValues[i]['name'], enableValues[i]['attribute_id'], enableValues[i]['attribute_name'], false)
            }

            // 构造skuData数据
            for (let i = 0; i < productSkus.length; i++) {
                skusData[productSkus[i]['attribute_value']] = productSkus[i];
            }

            if (allAttribute.length > 0) {
                createTable();
            }
        } else {
            $('.field-product-is-attribute-no').show();
            $('.field-product-is-attribute-yes').hide();
        }

        $('#product-isattribute input').change(function () {
            let isAttribute = $('#product-isattribute input:checked').val();
            if (parseInt(isAttribute) === 1) {
                $('.field-product-is-attribute-no').hide();
                $('.field-product-is-attribute-yes').show();
            } else {
                $('.field-product-is-attribute-no').show();
                $('.field-product-is-attribute-yes').hide();
            }
        })

        $('#product-attribute_set_id').change(function() {
            // 清空数据，删除sku表格
            allAttribute = skusData = [];
            createTable();

            let id = $(this).val();
            $.get("<?= Url::to(['attribute-set/view-ajax-value']); ?>?id=" + id, function(data, status) {
                if (status === "success") {
                    if (parseInt(data.code) === 200) {
                        let attributeHtml = template('attributeTemplate', data);
                        $('.table-product-attribute').html(attributeHtml);
                    }
                }
            });
        });
    });

    $(document).on("click", ".table-product-attribute .btn-attribute", function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let attributeId = $(this).data('attribute-id');
        let attributeName = $(this).data('attribute-name');

        if ($(this).hasClass('btn-default')) {
            $(this).removeClass('btn-default');
            $(this).addClass('btn-primary');

            addAttribute(id, name, attributeId, attributeName);
        } else {
            $(this).removeClass('btn-primary');
            $(this).addClass('btn-default');

            removeAttribute(id, name, attributeId, attributeName);
        }
    });

    function addAttribute(id, name, attributeId, attributeName, create = true) {
        var isExist = false;
        for (let i = 0; i < allAttribute.length; i++) {
            if (parseInt(allAttribute[i]['id']) === parseInt(attributeId)) {
                isExist = true;
            }
        }

        if (!isExist) {
            let attribute = [];
            attribute['id'] = attributeId;
            attribute['name'] = attributeName;
            attribute['values'] = [];

            allAttribute.push(attribute);
        }

        for (let i = 0; i < allAttribute.length; i++) {
            if (parseInt(allAttribute[i]['id']) === parseInt(attributeId)) {
                let attributeValue = [];
                attributeValue['id'] = id;
                attributeValue['name'] = name;

                allAttribute[i]['values'].push(attributeValue);
            }
        }

        if (create) {
            createTable();
        }
    }

    function removeAttribute(id, name, attributeId, attributeName) {
        for (let i = 0; i < allAttribute.length; i++) {
            if (parseInt(allAttribute[i]['id']) === parseInt(attributeId)) {
                for (let j = 0; j < allAttribute[i]['values'].length; j++) {
                    if (parseInt(allAttribute[i]['values'][j]['id']) === parseInt(id)) {
                        allAttribute[i]['values'].splice(j, 1)
                    }
                }

                // 属性下值都为空则删除属性
                if (allAttribute[i]['values'].length === 0) {
                    allAttribute.splice(i, 1)
                }
            }
        }
        console.log(allAttribute)
        createTable()
    }

    function createTable() {
        if (allAttribute.length > 0) {
            createTableHeader();
            createTableFooter();
            createTableBody();
            setSkusData();

            $('.block-product-sku').removeClass('hidden');
        } else {
            $('.block-product-sku').addClass('hidden');
        }
    }

    // 创建表格头
    function createTableHeader() {
        let data = [];
        data["attributes"] = [];
        for (let i = 0; i < allAttribute.length; i++) {
            data["attributes"][i] = allAttribute[i]['name'];
        }

        let htmlData = template('table-header', data);
        $(".table-product-sku thead").html(htmlData);
    }

    // 创建表格底部
    function createTableFooter() {
        let data = [];
        data['colspan']  = allAttribute.length + 7;

        let htmlData = template('table-footer', data);
        $(".table-product-sku tfoot").html(htmlData);
    }

    // 创建表格内容
    function createTableBody() {
        allSku = [];
        var allNum = 1;
        for (let i = 0; i < allAttribute.length; i++) {
            allNum *= allAttribute[i]['values'].length
        }

        // 总sku
        for (let i = 0; i < allNum; i++) {
            allSku[i] = [];
            allSku[i]['sku'] = '';
            allSku[i]['values'] = [];
        }

        // 重新排序sku
        var allLen = 1;
        for (let i = 0; i < allAttribute.length; i++) {
            var currentLen = 0;
            var values = allAttribute[i]['values'];
            // 每个循环次数
            var valuesCirculationNum = (allNum / allLen) / values.length;

            for (let j = 0; j < allLen; j++) {
                // 子级每次循环
                for (let k = 0; k < values.length; k++) {
                    for (let z = 0; z < valuesCirculationNum; z++) {
                        // 设置sku
                        let str = allSku[currentLen]['sku'].length > 0 ? ',' : '';
                        allSku[currentLen]['sku'] = allSku[currentLen]['sku'] + str + values[k]['id'];
                        // 设置属性名称
                        allSku[currentLen]['values'].push(values[k]);

                        currentLen++;
                    }
                }
            }

            allLen *= values.length;
        }

        // 渲染
        let data = [];
        data["data"] = allSku;
        $(".table-product-sku tbody").html(template('table-body', data));
    }

    function getSkusData() {
        $(".table-product-sku tbody tr").each(function () {
            let skuId = $(this);
        })
    }

    function setSkusData() {
        $(".table-product-sku tbody tr").each(function () {
            let skuId = $(this).attr('id');
            if (skusData.hasOwnProperty(skuId)) {
                $(this).find('.js-skus-0').val(skusData[skuId]['sku']);
                $(this).find('.js-skus-1').val(skusData[skuId]['price']);
                $(this).find('.js-skus-2').val(skusData[skuId]['market_price']);
                $(this).find('.js-skus-3').val(skusData[skuId]['cost_price']);
                $(this).find('.js-skus-4').val(skusData[skuId]['wholesale_price']);
                $(this).find('.js-skus-5').val(skusData[skuId]['stock']);
                $(this).find('.js-status').val(skusData[skuId]['status']);

                $(this).find('.js-thumb').val(skusData[skuId]['thumb']);
                if (skusData[skuId]['thumb'].length > 0) {
                    $(this).find('.selectImage').attr('src', skusData[skuId]['thumb']);
                } else {
                    $(this).find('.selectImage').attr('src', addSkuThumb);
                }
            } else {
                $(this).find('.selectImage').attr('src', addSkuThumb);
            }
        })

    }

    var imageObj;
    $(document).on("click", ".selectImage", function () {
        imageObj = $(this);
    })

    $(document).on("select-file-mall", function (e, boxId, data) {
        if (data.length > 0) {
            let url = data[0].url;
            $(imageObj).attr('src', url);
            $(imageObj).next().val(url);
        }
    })


    // 批量设置
    function batch(type) {
        let batchText = ["<?= Yii::t('app', 'Sku') ?>", "<?= Yii::t('app', 'Price') ?>"];

        $('.js-batch-form').removeClass('hidden');
        $('.js-batch-type').addClass('hidden');
        $('.js-batch-txt').attr('placeholder', batchText[type]);
        $('.js-batch-txt').focus();
        batchType = type;
    }

    // 报错批量设置
    $(document).on("click",".js-batch-save", function() {
        let batch_txt = $('.js-batch-txt');
        let val = batch_txt.val();
        if (batchType === 1 || batchType === 2 || batchType === 3 || batchType === 4) {
            val = parseFloat(val);
            if (val > 9999999.99) {
                fbWarning('Max 9999999.99');
                batch_txt.focus();
                return false;
            } else if (!/^\d+(\.\d+)?$/.test(batch_txt.val())) {
                fbWarning('请输入合法的价格');
                batch_txt.focus();
                return false;
            } else {
                batch_txt.val(val.toFixed(2));
            }
        }

        if (batchType === 5) {
            if (!/^\d+$/.test(batch_txt.val())) {
                rfWarning('请输入合法的数字');
                batch_txt.focus();
                return false;
            }

            $('.js-stock-num').val(val)
        }

        $('.js-skus-' + batchType).val(val);

        $('.js-batch-txt').val('');
        $('.js-batch-form').addClass('hidden');
        $('.js-batch-type').removeClass('hidden');
    });

    // 取消批量设置
    $(document).on("click", ".js-batch-cancel",function(){
        $('.js-batch-txt').val('');
        $('.js-batch-form').addClass('hidden');
        $('.js-batch-type').removeClass('hidden');
    });

</script>

<script>
    var colorUrl = "<?= Url::to(['/site/color', 'value' => ''])?>";
    var colorObj;
    // 选择颜色
    $(document).on("click", ".selectColor",function(){
        colorObj = $(this);
        var thisColorUrl = $(this).data('href');

        openIframeSelectColor(thisColorUrl);
    });

    // 打一个新窗口
    function openIframeSelectColor(url, color) {
        layer.open({
            type: 2,
            title: '<?= Yii::t('app', 'Select Color') ?>',
            shade: 0.3,
            offset: "10%",
            shadeClose: true,
            btn: ['<?= Yii::t('app', 'Ok') ?>', '<?= Yii::t('app', 'Close') ?>'],
            yes: function (index, layero) {
                var body = layer.getChildFrame('body', index);

                let color = body.find('.spectrum-input').val();
                $(colorObj).attr('style', "background:" + color + ";padding: 10px");
                $(colorObj).next().val(color);
                color = color.substr(1);
                $(colorObj).data('href', colorUrl + color);

                layer.closeAll();
            },
            btn2: function () {
                layer.closeAll();
            },
            area: ['40%', '300px'],
            content: url
        });

        return false;
    }
</script>

<script>
    $('#product-param_id').change(function() {

        let id = $(this).val();
        $.get("<?= Url::to(['param/view-ajax-child']); ?>?id=" + id, function(data, status) {
            if (status === "success") {
                if (parseInt(data.code) === 200) {
                    let paramHtml = template('paramTemplate', data);
                    $('.table-param').html(paramHtml);
                }
            }
        });
    });
</script>