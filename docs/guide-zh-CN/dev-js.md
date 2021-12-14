常用JS代码
------



### 网站加载后，$(document).ready(function () {  });

```js
<script>
    $(document).ready(function () {
        $('body').addClass('pt-0');
        $('nav').removeClass('fixed-top');
        $('#img1').attr('src', $('#img1').data('src'));
    });
</script>
```

### 