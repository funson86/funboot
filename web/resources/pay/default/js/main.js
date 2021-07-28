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

$('.nav a, #myCarousel a').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top - 60
    }, 1000);
    $('#w0-collapse').removeClass('show');
    return false;
});
$(document).ready(function () {
try {
    jQuery.cookieBar({
        message: 'We use cookies to give you the best experience on our website. By continuing, you agree to our use of cookies.',
        fixed: true,
        policyButton: false,
        expireDays: 60,
    });

    $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        animationLoop: true,
        slideshowSpeed: 5000
    });
} catch (e) {
    console.log(e);
}
});

