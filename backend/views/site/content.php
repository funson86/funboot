<?php
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\bootstrap4\Breadcrumbs;
use common\helpers\Url;

?>

<!-- 去除双滚动条 但是左侧栏目下滚动太深无法可见，如果要左侧栏目一直可见去掉样式代码 -->
<style type="text/css">
    html {
        overflow:hidden;
    }
</style>

<div class="content-wrapper">
    <div class="content-tabs hidden">
        <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-angle-double-left"></i></button>
        <nav class="page-tabs J_menuTabs" id="rftags">
            <div class="page-tabs-content">
                <a href="javascript:void (0);" class="active J_menuTab" data-id="<?= Url::to(['site/info'], false, false); ?>"><?= Yii::t('app', 'Home') ?></a>
                <!--默认主页需在对应的选项卡a元素上添加data-id="默认主页的url"-->
            </div>
        </nav>
        <button class="roll-nav roll-right J_tabRight"><i class="fa fa-angle-double-right"></i></button>
        <div class="btn-group roll-nav roll-right">
            <button class="dropdown J_tabClose" data-toggle="dropdown"><?= Yii::t('app', 'Actions') ?></button>
            <ul role="menu" class="dropdown-menu dropdown-menu-right">
                <li class="J_tabShowActive"><a><?= Yii::t('app', 'Locate Tab') ?></a></li>
                <li class="divider"></li>
                <li class="J_tabCloseAll"><a><?= Yii::t('app', 'Close All Tab') ?></a></li>
                <li class="J_tabCloseOther"><a><?= Yii::t('app', 'Close Other Tab') ?></a></li>
            </ul>
        </div>
        <a href="<?= Url::to(['site/logout']); ?>" data-method="post" class="roll-nav roll-right J_tabExit"><i class="nav-icon fas fa-sign-out-alt"></i> <?= Yii::t('app', 'Logout') ?></a>
    </div>
    <div class="J_mainContent" id="content-main">
        <!--默认主页需在对应的页面显示iframe元素上添加name="iframe0"和data-id="默认主页的url"-->
        <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?= Url::to(['site/info'], false, false); ?>" frameborder="0" data-id="<?= Url::to(['site/info'], false, false); ?>" seamless></iframe>
    </div>
</div>

<footer class="main-footer">
    <strong>Version <?= Yii::$app->params['system_version'] ?>  Copyright &copy; <?= date('Y') ?> <a href="https://github.com/funson86/funboot">Funboot</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>