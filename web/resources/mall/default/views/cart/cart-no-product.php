<?php
/* @var $this yii\web\View */
$this->registerCssFile($this->context->prefixStatic . '/css/cart.css', ['depends' => \frontend\assets\MallAsset::className()]);
$totalNumber = 0;
$totalPrice = 0;
foreach($products as $product) {
    $totalNumber += $product->number;
    $totalPrice += $product->number * $product->price;
}
?>

<div id="main">
    <div class="none-box cle">
        <p>去首页逛逛<a href="<?= Yii::$app->homeUrl ?>" class="btn">商城首页</a></p>
        <div class="txt">OR，嗖～一下</div>
        <div class="search_box_cart">
            <form action="<?= Yii::$app->urlManager->createUrl('/mall/product/search') ?>" method="get" id="search_fm" name="search_fm">
                <input class="sea_input" type="text" name="keyword" id="searchText" placeholder="请输入商品">
                <button type="submit" class="sea_submit"><i class="iconfont glyphicon glyphicon-search"></i></button>
            </form>
        </div>
    </div>
</div>

<?php
$js = <<<JS
jQuery("#searchText").focus(function(){
    if (jQuery("#searchText").val() == '请输入商品')
        jQuery("#searchText").val('');
});
jQuery("#searchText").blur(function(){
    if (jQuery("#searchText").val() == '')
        jQuery("#searchText").val('请输入商品');
});
jQuery("#search_fm").submit(function(){
    if (jQuery("#searchText").val() == '请输入商品' || jQuery("#searchText").val() == '')
        return false;
});
JS;

$this->registerJs($js);
