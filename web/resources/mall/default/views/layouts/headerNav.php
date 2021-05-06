<?php
use yii\helpers\Url;
use frontend\components\Nav;
use common\models\mall\Brand;
use common\models\mall\Category;

$query = new \yii\db\Query();
//$result = $query->select('sum(number) as number')->from('cart')->where(['or', 'session_id = "' . Yii::$app->session->id . '"', 'user_id = ' . (Yii::$app->user->id ? Yii::$app->user->id : -1)])->createCommand()->queryOne();
//$totalNumber = $result['number'];
$totalNumber = 1;

?>
<div class="hd_nav">
    <div class="hd_nav_bd cle">
        <div class="main_nav" id="main_nav">
            <div class="main_nav_link">
                <a href="javascript:;">全部商品分类</a>
            </div>
            <div class="main_cata" id="J_mainCata">
                <?php
                $allCategory = Category::get(0, Category::find()->asArray()->all());
                foreach ($allCategory as $category) {

                    if ($category["parent_id"] == 0) {
                        $menuItems[$category['id']] = [
                            'label' => $category['name'],
                            'url' => ['/mall/category/view', 'id' => $category['id']],
                        ];
                    } else {
                        $menuItems[$category['parent_id']]['items'][$category['id']] = [
                            'label' => $category['name'],
                            'url' => ['/mall/category/view', 'id' => $category['id']],
                        ];
                    }
                }

                echo Nav::widget([
                    'options' => ['class' => ''],
                    'items' => $menuItems,
                ]);
                ?>

            </div>
            <div class="J_subCata" id="J_subCata" style="top: 45px; opacity: 1; left: 213px;">
                <div class="J_subView" style="display: none;">
                    <dl>
                        <dt>奶粉</dt>
                        <dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 110401]) ?>">1段奶粉</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 110402]) ?>">2段奶粉</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 110403]) ?>">3段奶粉</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 110404]) ?>">4段奶粉</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 110405]) ?>">妈妈奶粉</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>宝宝辅食</dt>
                        <dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 110801]) ?>">米糊米粉</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 110803]) ?>">果蔬肉泥</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 110804]) ?>">饼干</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>非处方药</dt>
                        <dd class="kuan_cata">
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 111201]) ?>">叶酸</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 111202]) ?>">营养品</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 111203]) ?>">感冒药</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>宝宝用品</dt>
                        <dd class="kuan_cata">
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 112001]) ?>">奶瓶奶嘴</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 112002]) ?>">碗勺餐具</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 112003]) ?>">学饮杯</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 112004]) ?>">磨牙棒</a>
                        </dd>
                    </dl>

                    <dl>
                        <dt>宝宝纸尿裤</dt>
                        <dd class="kuan_cata">
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 1128]) ?>">全部纸尿裤</a>
                            <a href="<?= Url::to(['/mall/brand/view', 'id' => 26]) ?>">帮宝适</a>
                            <a href="<?= Url::to(['/mall/brand/view', 'id' => 31]) ?>">Naty纸尿裤</a>
                            <a href="<?= Url::to(['/mall/brand/view', 'id' => 32]) ?>">日本花王</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>推荐品牌</dt>
                        <dd class="brand_cata cle">
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 11, 'brand_id' => 4]) ?>"><img alt="the body shop" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_thebodyshop.png" title="the body shop"></a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 12, 'brand_id' => 16]) ?>"><img alt="simple" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_simple.png" title="simple"></a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 12, 'brand_id' => 27]) ?>"><img alt="no7" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_no7.png" title="no7"></a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 12, 'brand_id' => 17]) ?>"><img alt="NYR" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_NYR.png" title="NYR"></a>
                        </dd>
                    </dl>
                </div>
                <div class="J_subView" style="display: none;">
                    <dl>
                        <dt>美容护肤</dt>
                        <dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120104]) ?>">洁面</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120108]) ?>">化妆水/爽肤水</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120112]) ?>">乳液/面霜</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120116]) ?>">防晒</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120120]) ?>">眼部护理</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120124]) ?>">面部精华</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120136]) ?>">面膜/面膜粉</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>身体护理</dt>
                        <dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120404]) ?>">香水香精</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120408]) ?>">唇部护理</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120412]) ?>">身体保养</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120416]) ?>">手部保养</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120418]) ?>">洗发护发</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 120420]) ?>">其它</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>美妆彩妆</dt>
                        <dd class="mul">
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 1216]) ?>">美妆底妆</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 1220]) ?>">美妆润色</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 1224]) ?>">美妆眼妆</a>

                            <!--a href="<?= Url::to(['/mall/category/view', 'id' => 121604]) ?>">BB霜</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 121608]) ?>">隔离/妆前/打底</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 121612]) ?>">粉饼</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 121616]) ?>">粉底液/膏</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 121620]) ?>">遮瑕</a-->
                        </dd>
                    </dl>
                    <!--dl>
                        <dt>美妆润色</dt>
                        <dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122004]) ?>">唇膏/口红</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122008]) ?>">蜜粉/散粉</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122012]) ?>">唇彩/唇蜜</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122016]) ?>">腮红/胭脂</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122020]) ?>">指甲油/美甲产品</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122024]) ?>">修颜/高光/阴影粉</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>美妆眼妆</dt>
                        <dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122404]) ?>">眼线</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122408]) ?>">睫毛膏/睫毛增长液</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122412]) ?>">假睫毛/假睫毛工具</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122416]) ?>">粉底液/膏</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 122420]) ?>">遮瑕</a>
                        </dd>
                    </dl-->
                    <dl class="brand_cata">
                        <dt>推荐品牌</dt>
                        <dd class="brand_cata cle">
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 11, 'brand_id' => 4]) ?>"><img alt="the body shop" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_thebodyshop.png" title="the body shop"></a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 12, 'brand_id' => 16]) ?>"><img alt="simple" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_simple.png" title="simple"></a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 12, 'brand_id' => 27]) ?>"><img alt="no7" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_no7.png" title="no7"></a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 12, 'brand_id' => 17]) ?>"><img alt="NYR" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_NYR.png" title="NYR"></a>
                        </dd>
                    </dl>
                </div>
                <div class="J_subView" style="display: none;">
                    <dl>
                        <dt>人群分类</dt>
                        <dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130432]) ?>">孕妇儿童</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130420]) ?>">女性关爱</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130424]) ?>">老年关爱</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130428]) ?>">男性关爱</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130408]) ?>">上班族</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130412]) ?>">疲劳族</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130416]) ?>">夜猫族</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>功效分类</dt>
                        <dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130804]) ?>">基础营养</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130808]) ?>">美容防衰</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130812]) ?>">体重管理</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130816]) ?>">内分泌调理</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130820]) ?>">补肾强身</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130824]) ?>">睡眠压力</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130828]) ?>">视力保护</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130832]) ?>">心脑血管</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>营养分类</dt>
                        <dd>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130804]) ?>">蛋白质</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130808]) ?>">维生素</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130812]) ?>">矿物质</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130816]) ?>">蔬果</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130820]) ?>">补肾强身</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130824]) ?>">睡眠压力</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130828]) ?>">视力保护</a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 130832]) ?>">心脑血管</a>
                        </dd>
                    </dl>
                    <dl class="brand_cata">
                        <dt>推荐品牌</dt>
                        <dd class="brand_cata cle">
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 13, 'brand_id' => 25]) ?>"><img alt="holland and barrett" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_hollandandbarrett.png" title="holland and barrett"></a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 13, 'brand_id' => 11]) ?>"><img alt="vitaboiotics" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_vitaboiotics.png" title="vitaboiotics"></a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 13, 'brand_id' => 29]) ?>"><img alt="pregnacare" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_pregnacare.png" title="pregnacare"></a>
                            <a href="<?= Url::to(['/mall/category/view', 'id' => 13, 'brand_id' => 28]) ?>"><img alt="boots" src="http://7xiosd.com1.z0.glb.clouddn.com/menu_boots.png" title="boots"></a>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <ul class="sub_nav cle" id="sub_nav">
            <li><a href="<?= Yii::$app->homeUrl ?>" >首页</a></li>
            <li><a href="<?= Url::to('https://funmall.mayicun.com')  ?>">FunMall国际</a></li>
        </ul>
        <div class="hd_cart" id="head_cart">
            <a class="tit" href="<?= Url::to(['/mall/cart']) ?>"><b class="glyphicon glyphicon-shopping-cart"></b>去购物车结算<span><i class="glyphicon glyphicon-play"></i></span><em class="num" id="hd_cartnum" <?php if ($totalNumber > 0) { ?>style="visibility: visible"<?php } ?>><?= $totalNumber ?></em></a>
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
    jQuery(this).addClass('hd_cart_hover');
    jQuery.getJSON('{$urlCartList}', function(data, status) {
        if (status == "success") {
            var str = data_class = '';
            jQuery.each(data.data, function(l, v) {
                str += '<dl><dt><a target="_blank" href="/mall/product/' + v.product_id + '"><img src="' + v.thumb + '"></a></dt><dd><h4><a target="_blank" href="/mall/product/' + v.product_id + '">' + v.name + '</a></h4><p><span class="red">￥' + v.price + "</span>&nbsp;<i>X</i>&nbsp;" + v.number + '</p><a class="iconfont del" title="删除" href="javascript:;" data-lid="' + v.id + '" data-taocan="">删</a></dd></dl>';
                if (l > 5) {
                    data_class = " data_over";
                }
            });
            str += '<div class="data">' + data_class + '</div><div class="count">共<span class="red" id="hd_cart_count">' + data.totalNumber + '</span>件商品，满99元就包邮哦~<p>总价:<span class="red">￥<em id="hd_cart_total">' + data.totalPrice + '</em></span><a href="{$urlCart}" class="btn">去结算</a></p></div>';
            jQuery("#head_cart").find('.list').html(str);
        }
    })
});
jQuery("#head_cart").mouseleave(function(){
    jQuery(this).removeClass('hd_cart_hover');
});
JS;

$this->registerJs($js);
?>