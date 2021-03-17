<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\mall\Product as ActiveModel;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Product */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

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
                        <a class="nav-link" id="tab-2" data-toggle="pill" href="#tab-content-2"><?= Yii::t('app', 'Advanced') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-3" data-toggle="pill" href="#tab-content-3"><?= Yii::t('app', 'Stock Attribute') ?></a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="col-sm-12">
                    <?= $form->field($model, 'category_id')->dropDownList(\common\models\mall\Category::getIdLabel()) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'stock_code')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'stock')->textInput() ?>
                    <?= $form->field($model, 'stock_warning')->textInput() ?>
                    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'volume')->textInput(['maxlength' => true]) ?>
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
                    <?= $form->field($model, 'tags')->widget(kartik\select2\Select2::class, [
                        'data' => ['s1', 's2'], //传入变量
                        'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
                    ]) ?>
                    <?= $form->field($model, 'brief')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'brand_id')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'vendor_id')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'star')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'sales')->textInput() ?>
                    <?= $form->field($model, 'click')->textInput() ?>
                    <?= $form->field($model, 'type')->textInput() ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>

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
                                    <?php foreach ($attributes as $attribute){ ?>
                                        <tr>
                                            <td><?= $attribute->name ?></td>
                                            <td id="attribute-<?= $attribute->id; ?>">
                                                <?php foreach ($attribute->attributeValues as $value){ ?>
                                                <span id="attribute-value-<?= $value['id']; ?>" data-type="<?= $attribute['type']; ?>" class="btn btn-default btn-sm" data-id="<?= $value['id']; ?>" data-name="<?= $value['name']; ?>" data-attribute-id="<?= $attribute->id; ?>" data-attribute-name="<?= $attribute->name; ?>" data-sort="<?= $value['sort']; ?>"><?= $value['name']; ?></span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <div class="hint-block">点击按钮进行规格值设置, 选择按钮的情况下颜色/图片选项规格值才会被保存</div>
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
    {{each data as val i}}
    <tr>
        <td>{{val.name}}</td>
        <td>
            {{each val.values as item i}}
            <span id="option-{{item.id}}" data-type="{{val.type}}" class="btn btn-default btn-sm" data-id="{{item.id}}" data-name="{{item.name}}" data-attribute-id="{{val.id}}" data-attribute-name="{{val.name}}" data-sort="{{item.sort}}">{{item.name}}</span>
            {{/each}}
        </td>
    </tr>
    {{/each}}
    </tbody>
</script>

<!-- sku模板 -->
<script id="attributeTemplate" type="text/html">
    <tbody>
    {{each data as val i}}
    <tr>
        <td>{{val.name}}</td>
        <td>
            {{each val.values as item i}}
            <span id="option-{{item.id}}" data-type="{{val.type}}" class="btn btn-default btn-sm" data-id="{{item.id}}" data-title="{{item.name}}" data-name="{{val.name}}" data-sort="{{item.sort}}">{{item.name}}</span>
            {{/each}}
        </td>
    </tr>
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

    // 已经使用的属性项
    var enableValues = JSON.parse('<?= json_encode($enableValues); ?>');

    // 已经有数据的sku
    var productSkus = JSON.parse('<?= json_encode($productSkus); ?>');

    // 属性集下的属性数据
    var allAttribute = [];

    // 存储skus中的值，用来填充表格值
    var skusData = [];

    var addSkuThumb = "<?= \common\helpers\ImageHelper::get('/resources/images/add-sku.png') ?>";

    var batchType = 0;

    $(function () {
        let isAttribute = $('#product-isattribute input:checked').val();
        if (parseInt(isAttribute) === 1) {
            $('.field-product-is-attribute-no').hide();
            $('.field-product-is-attribute-yes').show();

            // 将属性项变蓝
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
            let id = $(this).val();
            $.get("<?= Url::to(['attribute-set/view-ajax-value']); ?>?id=" + id, function(data, status) {
                if (status === "success") {
                    if (parseInt(data.code) === 200) {
                        let attributeHtml = template('attributeTemplate', data);
                        //alert(attributeHtml)
                        $('.table-product-attribute').html(attributeHtml);
                    }
                }
            });
        });
    });

    $(document).on("click", ".table-product-attribute span", function() {
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

