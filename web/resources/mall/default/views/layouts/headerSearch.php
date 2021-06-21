<?php
use yii\helpers\Url;
?>

<div class="hd_main cle">
    <div class="logo">
        <p>
            <a href="<?= Yii::$app->homeUrl ?>" class="lizi_logo">商城</a>
        </p>
    </div>
    <div class="search_box">
        <form action="<?= Url::to(['/mall/product/search']) ?>" method="get" id="search_fm" name="search_fm" >
            <input class="sea_input" type="text" name="keyword" id="searchText" value="<?= Yii::$app->request->get('keyword') ?>" placeholder="<?= Yii::t('app', '请输入商品') ?>" />
            <button type="submit" class="sea_submit"><i class="iconfont glyphicon glyphicon-search"></i></button>
        </form>
    </div>
    <div class="head_search_hot">
        <span>热搜：</span>
        <a class="red" href="<?= Url::to(['product/search', 'keyword' => '爱他美']) ?>" target="_blank">爱他美</a>
        <a href="<?= Url::to(['product/search', 'keyword' => '牛栏']) ?>">牛栏</a>
        <a href="<?= Url::to(['product/search', 'keyword' => '辅食']) ?>">辅食</a>
        <a class="red" href="<?= Url::to(['product/search', 'keyword' => '面霜']) ?>">面霜</a>
        <a href="<?= Url::to(['product/search', 'keyword' => '鱼油']) ?>">鱼油</a>
        <a class="red" href="<?= Url::to(['product/search', 'keyword' => '奶粉']) ?>" target="_blank">奶粉</a>
    </div>
    <!--div class="intro">
        <ul>
            <li class="no1"><a href="#" target="_blank"><h4>正品保证</h4><p>中国人保承保</p></a></li>
            <li class="no2"><a href="#" target="_blank"><h4>7天退换货</h4><p>购物有保障</p></a></li>
            <li class="no3"><a href="#"  target="_blank"><h4>满59就包邮</h4><p>闪电发货</p></a></li>
        </ul>
    </div-->
</div>

<?php
$js = <<<JS
jQuery("#search_fm").submit(function(){
    if (jQuery("#searchText").val() == '') {
        return false;
    }
});
JS;

$this->registerJs($js);
?>
