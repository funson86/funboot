<?php
use common\helpers\Html;
use common\helpers\ArrayHelper;
use common\models\base\Attachment;
use common\helpers\Url;
?>

<div class="modal-header">
    <h4 class="modal-title"><?= Yii::t('app', 'File List') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-lg-2">
            <?= Html::dropDownList('year', '', ArrayHelper::merge(['' =>  Yii::t('app', 'All Years')] , ArrayHelper::dropListInt('2018', date('Y'))), [
                'class' => 'form-control',
                'id' => 'fbYear',
            ])?>
        </div>
        <div class="col-lg-2">
            <?= Html::dropDownList('month', '', ArrayHelper::merge(['' => Yii::t('app', 'All Months')] , ArrayHelper::dropListInt(1, 12)), [
                'class' => 'form-control',
                'id' => 'fbMonth',
            ])?>
        </div>
        <div class="col-lg-2">
            <?= Html::dropDownList('upload_type', '', ArrayHelper::merge(['' => Yii::t('app', 'All File Types')] , Attachment::getUploadTypeLabels()), [
                'class' => 'form-control',
                'id' => 'fbUploadType',
            ])?>
        </div>
        <div class="col-lg-3">
            <div class="input-group m-b">
                <?= Html::input('text', 'keyword', '', [
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app', 'Keywords'),
                    'id' => 'fbKeyword'
                ]); ?>
                <?= Html::tag('span', '<button class="input-group-text" onclick="fbAttachmentSearch()"><i class="fa fa-search"></i></button>', ['class' => 'input-group-append'])?>
            </div>
        </div>
        <div class="col-lg-3 text-right">
            <?= \common\components\uploader\FileWidget::widget([
                'name' => 'upload',
                'value' => '',
                'theme' => 'button',
                'uploadType' => $uploadType,
                'config' => [
                    'pick' => [
                        'multiple' => true,
                    ],
                ]
            ]) ?>
        </div>
    </div>
    <div style="padding-top: 15px">
        <ul class="mailbox-attachments clearfix" id="fbAttachmentList" data-multiple=""></ul>
    </div>
    <div class="row d-block text-center" id="loadingAttachment">
        <span onclick="fbGetAttachment()" class="btn btn-default"><?= Yii::t('app', 'Load More') ?></span>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
    <button class="btn btn-primary" data-dismiss="modal" id="fbAttachmentDetermine"><?= Yii::t('app', 'Ok') ?></button>
</div>

<script id="fbAttachmentTemplate" type="text/html">
    {{each data as value i}}
    <li>
        <div class="border-color-gray {{value.id}}" data-id="{{value.id}}" data-name="{{value.name}}" data-url="{{value.url}}" data-upload_type="{{value.upload_type}}">
            {{if value.upload_type == "image"}}
            <span class="mailbox-attachment-icon has-img">
                <img src="{{value.url}}" style="height: 130px">
            </span>
            {{else}}
            <span class="mailbox-attachment-icon">
                <i class="far fa-file-pdf"></i>
            </span>
            {{/if}}
            <div class="mailbox-attachment-info">
                <a href="{{value.url}}" target="_blank" class="mailbox-attachment-name">
                    <span><i class="fa fa-paperclip"></i> {{value.name}}</span>
                </a>
                <span class="mailbox-attachment-size">
                {{value.sizeLabel}}
                <a href="{{value.url}}" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fas fa-cloud-download-alt"></i></a>
            </span>
            </div>
        </div>
    </li>
    {{/each}}
</script>

<script>
    var page = 2;
    var year = month = keyword = uploadType = '';
    var boxId = "<?= $boxId ?>";


    var defaultPageData = [];
    defaultPageData['data'] = <?= $list ?>;
    var html = template('fbAttachmentTemplate', defaultPageData);

    document.getElementById('fbAttachmentList').innerHTML = html;

    // 选择图片
    $('#fbAttachmentDetermine').click(function () {
        let allData = [];
        $('#fbAttachmentList .active').each(function(i, data){
            var tmpData = [];
            tmpData['id'] = $(data).data('id');
            tmpData['url'] = $(data).data('url');
            tmpData['name'] = $(data).data('name');
            tmpData['upload_type'] = $(data).data('upload_type');
            allData.push(tmpData)
        });

        $(document).trigger('select-file-' + boxId, [boxId, allData]);
    });

    /**
     * 搜索
     */
    function fbAttachmentSearch() {
        year = $('#fbYear').val();
        month = $('#fbMonth').val();
        keyword = $('#fbKeyword').val();
        uploadType = $('#fbUploadType').val();
        page = 1;

        $('#fbAttachmentList').html('');
        fbGetAttachment();
    }

    function fbGetAttachment() {
        $.ajax({
            type:"get",
            url:"<?= Url::to(['/file/index', 'json' => true])?>",
            dataType: "json",
            data: {
                page:page,
                year: year,
                month: month,
                keyword: keyword,
                upload_type: uploadType,
            },
            success: function(data){
                if (data.code == 200) {
                    if (data.data.length > 0){
                        page++;
                        var html = template('fbAttachmentTemplate', data);
                        // 渲染添加数据
                        $('#fbAttachmentList').append(html);
                        $('#loadingAttachment').html('<span onclick="fbGetAttachment()" class="btn btn-default"><?= Yii::t('app', 'Load More') ?>></span>');
                    } else {
                        $('#loadingAttachment').text('<?= Yii::t('app', 'No more data') ?>');
                    }
                } else {
                    fbWarning(data.msg);
                }
            }
        });
    }
</script>

