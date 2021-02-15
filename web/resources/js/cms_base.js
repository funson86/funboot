// bindtop

onscroll = function() {
    var st = document.documentElement.scrollTop || document.body.scrollTop;
    if (!bind.offsetWidth && st >= 700) {
        bind.style.display = 'block';
    } else if (!!bind.offsetWidth && st < 700) {
        bind.style.display = 'none';
    }
}