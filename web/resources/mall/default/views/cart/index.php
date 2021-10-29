<?php
/* @var $this yii\web\View */
$this->registerCssFile('@web/css/cart.css');
$totalNumber = 0;
$totalPrice = 0;
foreach($products as $product) {
    $totalNumber += $product->number;
    $totalPrice += $product->number * $product->price;
}
?>

<div id="main">
    <div class="top-next cle">
        <div class="fl"> 我有账号，现在就<a href="javascript:;" id="login-link">登录</a> </div>
        <div class="fr"> <a href="<?= Yii::$app->homeUrl?>" class="graybtn">继续购物</a> <a href="javascript:;" class="btn" id="checkout-top">&nbsp;去下单&nbsp;</a> </div>
    </div>
    <div class="cart-box" id="cart-box">
        <div class="hd">
            <span class="no1">&nbsp;</span>
            <span class="no2" id="itemsnum-top"><?= $totalNumber ?>件商品</span>
            <span class="no3">单价</span>
            <span>数量</span>
            <span>小计</span>
        </div>
        <div class="goods-list">
            <ul>
                <?php foreach ($products as $product) { ?>
                <li class="cle hover">
                    <div class="check">
                        &nbsp;<!--input type="checkbox" name="goodsId" value="728286208" checked="checked" /-->
                    </div>
                    <div class="pic"> <a href="<?= Yii::$app->urlManager->createUrl(['product/view', 'id' => $product->product_id]) ?>" target="_blank"> <img alt="<?= $product->name ?>" src="<?= $product->thumb ?>"></a> </div>
                    <div class="name"> <a href="<?= Yii::$app->urlManager->createUrl(['product/view', 'id' => $product->product_id]) ?>" target="_blank"> <?= $product->name ?> </a>
                        <p> </p>
                    </div>
                    <div class="price-one">
                        <p>￥<em><?= $product->price ?></em></p>
                    </div>
                    <div class="nums">
                        <span class="minus" title="减少1个数量" data-link="<?= Yii::$app->urlManager->createUrl(['cart/index', 'type' => 'minus', 'product_id' => $product->product_id]) ?>">-</span>
                        <input type="text" data-limit="99"  data-link="<?= Yii::$app->urlManager->createUrl(['cart/index', 'type' => 'change', 'product_id' => $product->product_id]) ?>" value="<?= $product->number ?>">
                        <span class="add" title="增加1个数量" data-link="<?= Yii::$app->urlManager->createUrl(['cart/index', 'type' => 'add', 'product_id' => $product->product_id]) ?>">+</span>
                    </div>
                    <div class="price-xj"><span>￥</span> <em><?= $product->number * $product->price ?></em> </div>
                    <div class="del"> <a class="btn-del" href="<?= Yii::$app->urlManager->createUrl(['cart/delete', 'id' => $product->product_id]) ?>">删除</a></div>
                </li>
                <?php } ?>
            </ul>
        </div>
        <!-- 积分换购商品 -->
        <div class="fd cle">
            <div class="fl">
                <p class="no1">
                    <a id="del-all" href="<?= Yii::$app->urlManager->createUrl(['cart/destroy']) ?>">清空购物车</a>
                </p>
                <p><a class="graybtn" href="<?= Yii::$app->urlManager->createUrl(['/mall/product/search']) ?>">继续购物</a></p>
            </div>
            <div id="price-total" class="fr">
                <p><?= $totalNumber ?>件商品，总价：<span class="red">¥<strong><?= $totalPrice ?></strong></span></p>
                <p><?php if ($totalPrice >= Yii::$app->params['freeShipmentAmount']) { ?><span class="green">恭喜您，已免邮！</span><?php } else { ?><span class="red">运费<?= Yii::$app->params['defaultShipmentFee'] ?>元，满<?= Yii::$app->params['freeShipmentAmount'] ?>元包邮</span><?php } ?><a class="btn" href="javascript:;">去下单</a></p>
            </div>
        </div>
    </div>
</div>

<?php
$urlCurrent = Yii::$app->urlManager->baseUrl;
$urlCheckout = Yii::$app->urlManager->createUrl(['cart/checkout']);
$js = <<<JS
jQuery(".minus").click(function(){
    var link = $(this).data('link');
    $.get(link, function(data, status) {
        if (status == "success") {
            location.reload();
        }
    });
});//end click
jQuery(".add").click(function(){
    var link = $(this).data('link');
    $.get(link, function(data, status) {
        if (status == "success") {
            location.reload();
        }
    });
});//end click
jQuery(".nums input").change(function(){
    var link = $(this).data('link');
    $.get(link + "&value=" + this.value, function(data, status) {
        if (status == "success") {
            location.reload();
        }
    });
});//end click
jQuery(".btn").click(function(){
    location.href = '{$urlCheckout}';
});//end click
JS;

$this->registerJs($js);
