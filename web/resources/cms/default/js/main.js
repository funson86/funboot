$('.nav a, #myCarousel a').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top - 60
    }, 1000);
    $('#w0-collapse').removeClass('show');
    return false;
});
$(document).ready(function () {
    jQuery.cookieBar({
        message:'We use cookies to give you the best experience on our website. By continuing, you agree to our use of cookies.',
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
});
