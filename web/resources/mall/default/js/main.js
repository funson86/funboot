// 滚动到地方再动画
try {
    new WOW().init();
} catch (e) {
    console.log(e);
}

// 延迟加载
try {
    lazyload();
} catch (e) {
    console.log(e);
}

// 大于700显示
onscroll = function() {
    var st = document.documentElement.scrollTop || document.body.scrollTop;
    var goTop = document.getElementById('goTop');
    if (!goTop) return;
    if (!goTop.offsetWidth && st >= 700) {
        goTop.style.display = 'block';
    } else if (!!goTop.offsetWidth && st < 700) {
        goTop.style.display = 'none';
    }
}

// 平滑滑动到顶部
jQuery(function ($) {
    $(document).on("click", "#goTop", function () {
        $('html,body').animate({scrollTop: '0px'}, 800);
    })
})

// cookie bar
$(document).ready(function () {
    try {
        jQuery.cookieBar({
            message: 'We use cookies to give you the best experience on our website. By continuing, you agree to our use of cookies.',
            fixed: true,
            policyButton: false,
            expireDays: 60,
        });
    } catch (e) {
        console.log(e);
    }

    // set bg
    $('.set-bg').each(function() {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    // nice select
    $('select').niceSelect();
});

function changeURLArg(url, arg, argVal){
    var pattern= arg + '=([^&]*)';
    var replaceText = arg + '=' + argVal;
    if (url.match(pattern)) {
        var tmp='/(' + arg + '=)([^&]*)/gi';
        tmp = url.replace(eval(tmp), replaceText);
        return tmp;
    } else {
        if (url.match('[\?]')) {
            return url + '&' + replaceText;
        }else{
            return url + '?' + replaceText;
        }
    }
}
