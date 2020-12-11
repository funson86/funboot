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
