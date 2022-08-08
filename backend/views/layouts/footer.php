<?php

use common\helpers\Html;
use common\helpers\Url;
use common\helpers\CommonHelper;
use common\helpers\StringHelper;

?>

<!--ajax模拟框加载-->
<div class="modal fade" id="ajaxModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?= Html::img('@web/resources/images/loading.gif', ['class' => 'loading']) ?>
                <span><?= Yii::t('app', 'Loading') ?></span>
            </div>
        </div>
    </div>
</div>
<!--ajax大模拟框加载-->
<div class="modal fade" id="ajaxModalLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <?= Html::img('@web/resources/images/loading.gif', ['class' => 'loading']) ?>
                <span><?= Yii::t('app', 'Loading') ?></span>
            </div>
        </div>
    </div>
</div>
<!--ajax最大模拟框加载-->
<div class="modal fade" id="ajaxModalMax" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%; max-width: 80%">
        <div class="modal-content">
            <div class="modal-body">
                <?= Html::img('@web/resources/images/loading.gif', ['class' => 'loading']) ?>
                <span><?= Yii::t('app', 'Loading') ?></span>
            </div>
        </div>
    </div>
</div>
<!--初始化模拟框-->
<div id="fbModalBody" class="hidden">
    <div class="modal-body">
        <?= Html::img('@web/resources/images/loading.gif', ['class' => 'loading']) ?>
        <span><?= Yii::t('app', 'Loading') ?></span>
    </div>
</div>

<?php

list($fullUrl, $pageConnector) = CommonHelper::getPageSkipUrl();

$page = (int)Yii::$app->request->get('page', 1);
$pageSize = (int)Yii::$app->request->get('page_size', 10);

$perPageSelect = Html::dropDownList('fb-page_size', $pageSize, [
    10 => Yii::t('app', '10 per page'),
    15 => Yii::t('app', '15 per page'),
    25 => Yii::t('app', '25 per page'),
    50 => Yii::t('app', '50 per page'),
], [
    'class' => 'form-control fb-page_size',
    'style' => 'width:100px'
]);

$perPageSelect = StringHelper::replace("\n", '', $perPageSelect);

$script = <<<JS

$(".pagination").append('<li style="float: left;margin-left: 10px;">$perPageSelect</li>');
$(".pagination").append('<li>&nbsp;&nbsp;' + fbT('Goto') + '&nbsp;<input id="page_no" type="text" class="form-control form-control-page-no"/>&nbsp;' + fbT('Page') + '</li>');
    
// 选择分页数量
$('.fb-page_size').change(function() {
    var page = $('#invalue').val();
    if (!page) {
        page = '{$page}';
    }

    location.href = "{$fullUrl}" + "{$pageConnector}page="+ parseInt(page) + '&page_size=' + $(this).val();
});

// 跳转页码
$('#page_no').blur(function() {
    goToPage();
});
$('#page_no').keydown(function(event) {
    if (event.keyCode === 13) {
        goToPage();
    }
});
function goToPage() {
    var page = $('#page_no').val();
    if (!page) {
        return;
    }
    
    if (parseInt(page) > 0) {
          location.href = "{$fullUrl}" + "{$pageConnector}page="+ parseInt(page) + '&page_size=' + $('.fb-page_size').val();
    } else {
        $('#page_no').val('');
        fbError(fbT('Please input correct page'));
    }
}
JS;

$this->registerJs($script, \yii\web\View::POS_END);
?>

<?php
$urlEditAjaxField = Url::to(['edit-ajax-field'], false, false);
$urlEditAjaxStatus = Url::to(['edit-ajax-status'], false, false);
$csrf = Yii::$app->request->getCsrfToken();
$js = <<<JS
// 小模拟框清除
$('#ajaxModal').on('hide.bs.modal', function (e) {
    if (e.target == this) {
        $(this).removeData("bs.modal");
        $('#ajaxModal').find('.modal-content').html($('#fbModalBody').html());
    }
});
// 大模拟框清除
$('#ajaxModalLarge').on('hide.bs.modal', function (e) {
    if (e.target == this) {
        $(this).removeData("bs.modal");
        $('#ajaxModalLarge').find('.modal-content').html($('#fbModalBody').html());
    }
});
// 最大模拟框清除
$('#ajaxModalMax').on('hide.bs.modal', function (e) {
    if (e.target == this) {
        $(this).removeData("bs.modal");
        $('#ajaxModalMax').find('.modal-content').html($('#fbModalBody').html());
    }
});

// 小模拟框加载完成
$('#ajaxModal').on('shown.bs.modal', function (e) {
    modalShow($(this), e, '#ajaxModal');
});
// 大模拟框加载完成
$('#ajaxModalLarge').on('shown.bs.modal', function (e) {
    modalShow($(this), e, '#ajaxModalLarge')
});
// 最模拟框加载完成
$('#ajaxModalMax').on('shown.bs.modal', function (e) {
    modalShow($(this), e, '#ajaxModalMax')
});

function modalShow(obj, e, modalId) {
    let href = $(e.relatedTarget).attr("href");
    if (href.indexOf('javascript') != -1) {
        fbWarning(fbT('No Auth'))
        $(modalId).modal('hide')
    } else {
        obj.find('.modal-content').load($(e.relatedTarget).attr("href"));
    }
}

// 启用状态 status 1:启用;0禁用;
function fbStatus(obj) {
    let self = $(obj);
    let id = self.attr('data-id');
    let status = parseInt(self.data('status'));
    let nextStatus = 1;
    if (status === 1) {
        nextStatus = 0;
    } else {
        nextStatus = 1;
    }

    if (!id) {
        id = self.parents('tr').attr('data-key');
    }

    $.ajax({
        type: "post",
        url: "{$urlEditAjaxStatus}?id=" + id,
        dataType: "json",
        data: {
            id: id,
            status: nextStatus
        },
        success: function (data) {
            if (parseInt(data.code) === 200) {
                toastSuccess(data.msg)
                self.data('status', data.data.status)
                if (parseInt(data.data.status) === 1) {
                    self.html('<span class="btn btn-success btn-xs">' + fbT('Enable') + '</span><span class="btn btn-default btn-xs">&nbsp;</span>');
                } else {
                    self.html('<span class="btn btn-default btn-xs">&nbsp;</span><span class="btn btn-warning btn-xs">' + fbT('Disable') + '</span>');
                }
            } else {
                fbError(data.msg);
            }
        }
    });
}

// 排序
function fbSort(obj) {
    let self = $(obj);
    let id = self.attr('data-id');

    if (!id) {
        id = self.parents('tr').attr('data-key');
    }

    var sort = self.val();
    if (isNaN(sort)) {
        fbError(fbT('Only number required'));
        return false;
    } else {
        $.ajax({
            type: "post",
            url: "{$urlEditAjaxField}?id=" + id,
            dataType: "json",
            data: {
                id: id,
                field: "sort",
                value: sort
            },
            success: function (data) {
                if (parseInt(data.code) === 200) {
                    toastSuccess(data.msg)
                } else {
                    fbError(data.msg);
                }
            }
        });
    }
}

// ajax更新字段
function fbField(obj) {
    let self = $(obj);
    let id = self.attr('data-id');

    if (!id) {
        id = self.parents('tr').attr('data-key');
    }

    var field = self.attr('name');
    var value = self.val();
    $.ajax({
        type: "post",
        url: "{$urlEditAjaxField}?id=" + id,
        dataType: "json",
        data: {
            id: id,
            field: field,
            value: value
        },
        success: function (data) {
            if (parseInt(data.code) === 200) {
                toastSuccess(data.msg)
            } else {
                fbError(data.msg);
            }
        }
    });
}

// 删除提示
function fbDelete(obj, text) {
    if (!text) {
        text = fbT('Do it carefully');
    }
    let title = fbT('Are you sure to delete this record?');

    Swal.fire({
        title: title,
        text: text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: fbT('Ok'),
        cancelButtonText: fbT('Cancel')
    }).then((result) => {
        if (result.value) {
            postLink($(obj).attr('href'), {'_csrf-backend': '$csrf'});
            // window.location = $(obj).attr('href');
        }
    });
}

// 删除提示
function fbConfirm(obj, text) {
    if (!text) {
        text = fbT('Do it carefully');
    }
    let title = fbT('Are you sure to do this operation?');

    Swal.fire({
        title: title,
        text: text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: fbT('Ok'),
        cancelButtonText: fbT('Cancel')
    }).then((result) => {
        if (result.value) {
            postLink($(obj).attr('href'), {'_csrf-backend': '$csrf'});
            // window.location = $(obj).attr('href');
        }
    });
}

function hideAlert() {
    $('.alert').hide(2000);
}
// 10秒后自动关闭错误提示
setTimeout(function(){
    hideAlert();  
}, 10000);
$('[data-toggle="tooltip"]').tooltip();
JS;

$this->registerJs($js, \yii\web\View::POS_END);

