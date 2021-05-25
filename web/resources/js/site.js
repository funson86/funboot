function postLink(url, data, name = '_self')
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
        console.log(data)
        if (data) {
            // 如果是第一次 submit 并且 客户端验证有效，那么进行正常 submit 流程
            console.log($form.data('funboot.submitting'))
            console.log(!$form.data('funboot.submitting') && data.validated)
            if (!$form.data('funboot.submitting') && data.validated) {
                $form.data('funboot.submitting', true);
                return true;
            } else { //  否则阻止提交
                return false;
            }
        }
        return true;
    });

});
