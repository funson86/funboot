var skins = [
    'skin-blue',
    'skin-black',
    'skin-red',
    'skin-yellow',
    'skin-purple',
    'skin-green',
    'skin-blue-light',
    'skin-black-light',
    'skin-red-light',
    'skin-yellow-light',
    'skin-purple-light',
    'skin-green-light'
];

// local storage
function getStorage(name) {
    if (typeof (Storage) !== 'undefined') {
        return localStorage.getItem(name)
    } else {
        window.alert('Please use a modern browser to properly view this template!')
    }
}
function setStorage(name, val) {
    if (typeof (Storage) !== 'undefined') {
        localStorage.setItem(name, val)
    } else {
        window.alert('Please use a modern browser to properly view this template!')
    }
}
// end of local storage

function changeSkin(cls) {
    $.each(skins, function (i) {
        $('body').removeClass(skins[i])
    })

    $('body').addClass(cls)
    setStorage('skin', cls)
    return false
}

$('[data-sidebarskin="toggle"]').on('click', function () {
    var $sidebar = $('.control-sidebar')
    if ($sidebar.hasClass('control-sidebar-dark')) {
        $sidebar.removeClass('control-sidebar-dark')
        $sidebar.addClass('control-sidebar-light')
    } else {
        $sidebar.removeClass('control-sidebar-light')
        $sidebar.addClass('control-sidebar-dark')
    }
})

$('[data-skin]').on('click', function (e) {
    changeSkin($(this).data('skin'))
})

var tmp = getStorage('skin')
if (tmp && $.inArray(tmp, skins)) {
    changeSkin(tmp)
}

//i18n翻译
function fbT(msgVariable, data, msg) {
    if (typeof i18nLocal !== "undefined") {
        if (msg !== undefined) i18nLocal[msgVariable].push(msg);
        return i18nLocal[msgVariable].replace('{val}', data);
    } else {
        return msg;
    }
}
