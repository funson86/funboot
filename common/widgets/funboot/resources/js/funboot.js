
if (config == NaN) {
    let config = {
        isMobile: false
    };
}

function fbSuccess(content, title = '') {
    //Swal.fire(title, content, 'success')
    toastr.options = {
        "closeButton": true, //是否显示关闭按钮
        "positionClass": "toast-center-center",//弹出窗的位置
        "hideDuration": "1000",//消失的动画时间
        "timeOut": "3000", //展现时间
    };
    toastSuccess(content)
}
function fbError(content, title = '') {
    Swal.fire(title, content, 'error')
}
function fbInfo(content, title = '') {
    Swal.fire(title, content, 'info')
}
function fbWarning(content, title = '') {
    // Swal.fire(title, content, 'warning')
    toastr.options = {
        "closeButton": true, //是否显示关闭按钮
        "positionClass": "toast-center-center",//弹出窗的位置
        "hideDuration": "1000",//消失的动画时间
        "timeOut": "5000", //展现时间
    };
    toastr.error(content)
}

function flashSuccess(msg) {
    $(".content").prepend('<div id="w1-success" class="alert-success alert in">' +
        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
        '<i class="icon fa fa-check"></i>' +
        msg + '</div>');
}

function flashError(msg) {
    $(".content").prepend('<div id="w1-error" class="alert-error alert in">' +
        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
        '<i class="icon fa fa-check"></i>' +
        msg + '</div>');
}

function toastSuccess(msg) {
    toastr.success(msg)
}

function messageWarning(content, title = '') {
    // Swal.fire(title, content, 'warning')
    toastr.options = {
        "closeButton": true, //是否显示关闭按钮
        "positionClass": "toast-top-right",//弹出窗的位置
        "showDuration": "300",//显示的动画时间
        "hideDuration": "1000",//消失的动画时间
        "timeOut": "5000", //展现时间
    };
    toastr.error(content)
}

// 提示
function fbPrompt(url, text) {
    if (!text) {
        text = '请谨慎操作';
    }
    let title = "您确定要执行吗?";

    Swal.fire({
        title: title,
        text: text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: '确定',
        cancelButtonText: '取消'
    }).then((result) => {
        if (result.value) {
            window.location = url;
        }
    });
}

$(document).ready(function () {
    if ($(this).width() < 769) {
        config.isMobile = true;
    }

    autoChangeMenu(true);
});

$(window).resize(function () {
    var leftAuto = true;
    if (!config.isMobile) {
        leftAuto = false;
    }

    if ($(this).width() < 769) {
        config.isMobile = true;
    } else {
        config.isMobile = false;
    }

    if (!config.isMobile && !leftAuto) {
        autoChangeMenu();
    } else {
        autoChangeMenu(true);
    }
});
function autoChangeMenu(leftAuto = false) {
    // 改变框架高度
    var mainContent = window.innerHeight - 143;
    if (config.isMobile) {
        mainContent = mainContent + 40;
    }
    $(".J_mainContent").height(mainContent);

    if (config.isMobile == true) {
        // 显示左边菜单
        $('.fbLeftMenu').removeClass('hidden');
        // 隐藏tag
        $(".content-tabs").addClass('hidden');
        // 显示退出
        $("#logout").removeClass('hidden');
        // 隐藏头部菜单栏
        $('.fbTopMenu').each(function (i, data) {
            var type = $(this).data('type');
            if (type) {
                $(this).addClass('hidden');
            }
        });

        // 增加样式
        $(".J_mainContent").addClass('fbMainContent');
        // 底部隐藏
        $(".main-footer").addClass('hidden');
    } else {
        if (leftAuto == true) {
            // 隐藏左边菜单
            $('.fbLeftMenu').addClass('hidden');
            // 默认菜单显示
            $('.is_default_show').removeClass('hidden');
        }

        // 头部菜单栏
        $('.fbTopMenu').removeClass('hidden');
        // 显示标签
        $('.content-tabs').removeClass('hidden');
        // 隐藏退出
        $("#logout").addClass('hidden');
        // 移除样式
        $(".J_mainContent").removeClass('fbMainContent');
        // 底部显示
        $(".main-footer").removeClass('hidden');
    }

    // 判断顶部菜单显示状态
    if (config.isMobile == false) {

        $('.navbar-static-top .pull-left ul li').removeClass('hidden');
        $('.hide-menu ul li ul').html('');

        var leftWidth = $('.navbar-static-top').width() - $('.navbar-static-top .top-right').width() - 70;

        if (leftWidth < $('.navbar-static-top .pull-left').width()) {
            var tmpWith = 0;

            // 移动菜单显示
            $('.navbar-static-top .pull-left ul li').each(function (i, item) {
                tmpWith += $(item).width();

                if (tmpWith > leftWidth) {
                    $(item).addClass('hidden');
                    $('.hide-menu').removeClass('hidden');
                    // 增加一次的菜单
                    $('.hide-menu ul li ul').append("<li class='fbTopMenu' data-type=" + $(item).data('type') + " data-addon_centre=" + $(item).data('addon_centre') + ">" + $(item).html() + "</li>")
                }

                $('.hide-menu ul li ul').find('a').addClass("pointer");
                $('.hide-menu ul li ul').find('i').addClass("fb-i m-l-sm");
            })
        } else {
            $('.hide-menu').addClass('hidden');
        }
    } else {
        $('.hide-menu').addClass('hidden');
    }
}

/* 在顶部导航栏打开tab */
$(document).on("click", ".openConTab", function (e) {
    parent.openConTab($(this));
    return false;
});

// 关闭当前的标签
$(document).on("click", ".closeCurrentConTab", function (e) {
    parent.closeCurrentConTab();
    return false;
});

/* 打一个新窗口 */
$(document).on("click", ".openIframe", function (e) {
    var title = $(this).data('title');
    var width = $(this).data('width');
    var height = $(this).data('height');
    var offset = $(this).data('offset');
    var href = $(this).attr('href');

    if (title == undefined) {
        title = '基本信息';
    }

    if (width == undefined) {
        width = '80%';
    }

    if (height == undefined) {
        height = '80%';
    }

    if (offset == undefined) {
        offset = "10%";
    }

    openIframe(title, width, height, href, offset);
    e.preventDefault();
    return false;
});

layer.config({
    extend: 'style.css', //加载您的扩展样式
});

// 打一个新窗口
function openIframe(title, width, height, content, offset) {
    layer.open({
        type: 2,
        title: title,
        shade: 0.3,
        offset: offset,
        shadeClose: true,
        btn: ['保存', '关闭'],
        yes: function (index, layero) {
            var body = layer.getChildFrame('body', index);
            var form = body.find('#w0');
            var postUrl = form.attr('action');
            $.ajax({
                type: "post",
                url: postUrl,
                dataType: "json",
                data: form.serialize(),
                success: function (data) {
                    if (parseInt(data.code) !== 200) {
                        fbWarning(data.msg);
                    } else {
                        layer.close(index);
                        location.reload();
                    }
                }
            });
        },
        btn2: function () {
            layer.closeAll();
        },
        area: [width, height],
        content: content
    });

    return false;
}

$('.fbTopNav').click(function () {
    let id = $(this).data('id');
    $('.fbLeftMenuCat').addClass('hidden');
    $('.fbLeftMenuCat').parent().addClass('hidden');
    $('.fbLeftMenuCat-' + id).removeClass('hidden');
    $('.fbLeftMenuCat-' + id).parent().removeClass('hidden');
})

function postLink(url, data = '', name = '_self')
{
    var tempForm = document.createElement("form");
    tempForm.id = "tempForm1";
    tempForm.method = "post";
    tempForm.action = url;
    tempForm.target = name;    // _blank - URL加载到一个新的窗口

    var hideInput = document.createElement("input");
    hideInput.type = "hidden";
    hideInput.name = "content";
    hideInput.value = data;
    tempForm.appendChild(hideInput);
    // 可以传多个参数
    /* var nextHideInput = document.createElement("input");
    nextHideInput.type = "hidden";
    nextHideInput.name = "content";
    nextHideInput.value = data;
    tempForm.appendChild(nextHideInput); */
    if(document.all){    // 兼容不同浏览器
        tempForm.attachEvent("onsubmit",function(){});        //IE
    }else{
        tempForm.addEventListener("submit",function(){},false);    //firefox
    }
    document.body.appendChild(tempForm);
    if(document.all){    // 兼容不同浏览器
        tempForm.fireEvent("onsubmit");
    }else{
        tempForm.dispatchEvent(new Event("submit"));
    }
    tempForm.submit();
    document.body.removeChild(tempForm);
}

jQuery(function ($) {

    // 防止重复提交
    $(document).on("submit", "form", function() {
        var $form = $(this),
            data = $form.data('yiiActiveForm');
        if (data) {
            // 如果是第一次 submit 并且 客户端验证有效，那么进行正常 submit 流程
            if (!$form.data('funboot.submitting') && data.validated) {
                $form.data('funboot.submitting', true);
                return true;
            } else { //  否则阻止提交
                return false;
            }
        }
    });

});
