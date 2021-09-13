jQuery(function ($) {

    $(document).on("click", "#goTop", function () {
        $('html,body').animate({scrollTop: '0px'}, 800);
    }).on("click", "#goBottom", function () {
        $('html,body').animate({scrollTop: $('.footer').offset().top}, 800);
    }).on("click", "#refresh", function () {
        location.reload();
    });

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

jQuery(function ($) {

    //赞, 踩, 收藏 等操作
    $(document).on('click', '[data-action]', function (e) {
        var _this = $(this),
            _id = _this.data('id'),
            _do = _this.data('action'),
            _type = _this.data('type');
        if (_this.is('a')) e.preventDefault();
        $.ajax({
            url: '/bbs/user-action/' + [_do, _type, _id].join('/'),
            success: function (result) {
                if (result.code != 200) {
                    return alert(result.msg);
                }

                window.location.reload();
            }
        });
    });
});
