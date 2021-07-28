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
