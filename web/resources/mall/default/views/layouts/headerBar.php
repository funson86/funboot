<?php
use yii\helpers\Url;
?>

<div class="hd_bar">
    <div class="bd_bar_bd cle">
        <ul class="welcome">
            <li><a id="favorite_wb" href="javascript:;" rel="nofollow">收藏商城</a></li>
            <li id="header_user">
                <?php if (Yii::$app->user->isGuest) { ?>
                    <a href="<?= Url::to(['/mall/default/login']) ?>" rel="nofollow">请登录</a><s>|</s><a href="<?= Url::to(['/mall/default/signup']) ?>" rel="nofollow">免费注册</a>
                <?php } else { ?>
                    <a class="" href="<?= Url::to(['/mall/user']) ?>"><?= Yii::$app->user->identity->username ?></a>&nbsp;[<a href="<?= Url::to(['/site/logout']) ?>">退出</a>]
                <?php } ?>
            </li>
        </ul>
        <ul id="userinfo-bar">
            <li><a href="<?= Url::to(['/mall/order']) ?>">我的订单</a></li>
            <li><a href="<?= Url::to(['/mall/user/favorite']) ?>">我的收藏</a></li>
            <!--<li><a class="menu-link" href="<?= Url::to(['/cms/default/page', 'id' => 11, 'surname' => 'register']) ?>">帮助中心</a></li>-->
        </ul>
    </div>
</div>

<?php
$homeUrl = \yii\helpers\Url::home(true);
$homeDescription = Yii::$app->name;
$js = <<<JS
jQuery("#favorite_wb").click(function(){
    var h = "{$homeUrl}",
    j = "{$homeDescription}";
    try {
        window.external.addFavorite(h, j);
    } catch(i) {
        try {
            window.sidebar.addPanel(j, h, "");
        } catch(i) {
            alert("对不起，您的浏览器不支持此操作！请您使用菜单栏或Ctrl+D收藏家家优品。");
        }
    }
});
JS;
$this->registerJs($js);
?>