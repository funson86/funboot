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
