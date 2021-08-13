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

