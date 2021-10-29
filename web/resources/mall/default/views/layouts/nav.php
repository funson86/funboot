<?php
use yii\helpers\Url;
use frontend\components\MallNav;
use common\models\mall\Brand;
use common\models\mall\Category;
use common\helpers\ArrayHelper;
use yii\helpers\Html;

$query = new \yii\db\Query();
//$result = $query->select('sum(number) as number')->from('cart')->where(['or', 'session_id = "' . Yii::$app->session->id . '"', 'user_id = ' . (Yii::$app->user->id ? Yii::$app->user->id : -1)])->createCommand()->queryOne();
//$totalNumber = $result['number'];
$totalNumber = 1;

$store = $this->context->store;
$categories = Category::find()->where(['store_id' => $store->id])->asArray()->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
$categoriesTree = ArrayHelper::tree($categories);

$brands = Brand::find()->where(['store_id' => $store->id])->asArray()->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
?>
<div class="hd_nav">
    <div class="hd_nav_bd cle">
        <div class="main_nav" id="main_nav">
            <div class="main_nav_link">
                <a href="javascript:;"><?= Yii::t('app', 'All Categories') ?></a>
            </div>
            <div class="main_cate" id="J_mainCata">
                <?php
                foreach ($categoriesTree as $item) {
                    $menuItems[$item['id']] = [
                        'label' => fbt(Category::getTableCode(), $item['id'], 'name', $item['name']),
                        'url' => ['/mall/category/view', 'id' => $item['id']],
                    ];
                }

                echo MallNav::widget([
                    'options' => ['class' => ''],
                    'items' => $menuItems,
                ]);
                ?>

            </div>
            <div class="J_subCata" id="J_subCata" style="top: 45px; opacity: 1; left: 213px;">
                <?php foreach ($categoriesTree as $item) { ?>
                <div class="J_subView" style="display: none;">
                    <?php foreach ($item['children'] as $child) { ?>
                    <dl>
                        <dt><a href="<?= Url::to(['/mall/category/view', 'id' => $child['id']]) ?>"><?= fbt(Category::getTableCode(), $child['id'], 'name', $child['name']) ?></a></dt>
                        <!--dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 110401]) ?>">1段奶粉</a>
                        </dd-->
                    </dl>
                    <?php } ?>
                    <dl>
                        <dt style="font-size: 14px; margin-top: 12px"><?= Yii::t('app', 'Recommended Brands') ?></dt>
                        <dd class="brand_cata cle">
                            <?php foreach ($brands as $brand) { ?>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => $item['id'], 'brand_id' => $brand['id']]) ?>"><?= Html::img($brand['logo']) ?></a>
                            <?php } ?>
                        </dd>
                    </dl>
                </div>
                <?php } ?>
            </div>
        </div>
        <ul class="sub_nav cle" id="sub_nav">
            <li><a href="<?= Yii::$app->homeUrl . '?lang=' . Yii::$app->language ?>" ><?= Yii::t('app', 'Home') ?></a></li>
            <li><a href="<?= Url::to('https://funmall.funboot.net?lang='  . Yii::$app->language)  ?>"><?= Yii::t('app', 'Global') ?></a></li>
        </ul>
        <div class="nav_cart" id="head_cart">
            <a class="tit" href="<?= Url::to(['/mall/cart']) ?>"><b class="fa fa-shopping-cart"></b><?= Yii::t('app', 'Shopping Cart') ?><span><i class="fa fa-play"></i></span><em class="num" id="nav_cartnum" <?php if ($totalNumber > 0) { ?>style="visibility: visible"<?php } ?>><?= $totalNumber ?></em></a>
            <div class="list"><p class="load"></p></div>
        </div>
    </div>
</div>

<?php
$urlCartList = Url::to('/mall/cart/json-list');
$urlCart = Url::to('/mall/cart');

$js = <<<JS
jQuery(function() {
    var isHome = true;
    jQuery(this).addClass('main_nav_hover');
    jQuery("#J_mainCata").css({"opacity":0.9,"height":95,"display":"block"})
})

jQuery("#main_nav").mouseenter(function(){
    jQuery(this).addClass('main_nav_hover');
    jQuery("#J_mainCata").css({"opacity":1,"height":95,"display":"block"})
});
jQuery("#main_nav").mouseleave(function(){
    jQuery(this).removeClass('main_nav_hover');
    jQuery("#J_mainCata").css({"opacity":0,"height":0,"display":"none"});
    jQuery("#J_subCata").find(".J_subView").hide();
});
jQuery("#J_mainCata li").mouseenter(function(){
    var index = jQuery("#J_mainCata li").index(this);
    jQuery(this).css({"background":'#3a4e9e', 'border-right-color':'#3a4e9e'});
    jQuery("#J_subCata").find(".J_subView").hide().eq(index).show();
});
jQuery("#J_mainCata li").mouseleave(function(){
    jQuery(this).css({"background":'#4b5fad'});
});
jQuery("#head_cart").mouseenter(function(){
    jQuery(this).addClass('nav_cart_hover');
    jQuery.getJSON('{$urlCartList}', function(data, status) {
        if (status == "success") {
            var str = data_class = '';
            jQuery.each(data.data, function(l, v) {
                str += '<dl><dt><a target="_blank" href="/mall/product/' + v.product_id + '"><img src="' + v.thumb + '"></a></dt><dd><h4><a target="_blank" href="/mall/product/' + v.product_id + '">' + v.name + '</a></h4><p><span class="red">￥' + v.price + "</span>&nbsp;<i>X</i>&nbsp;" + v.number + '</p><a class="iconfont del" title="删除" href="javascript:;" data-lid="' + v.id + '" data-taocan="">删</a></dd></dl>';
                if (l > 5) {
                    data_class = " data_over";
                }
            });
            str += '<div class="data">' + data_class + '</div><div class="count">共<span class="red" id="nav_cart_count">' + data.totalNumber + '</span>件商品，满99元就包邮哦~<p>总价:<span class="red">￥<em id="nav_cart_total">' + data.totalPrice + '</em></span><a href="{$urlCart}" class="btn">去结算</a></p></div>';
            jQuery("#head_cart").find('.list').html(str);
        }
    })
});
jQuery("#head_cart").mouseleave(function(){
    jQuery(this).removeClass('nav_cart_hover');
});
JS;

$this->registerJs($js);
?>