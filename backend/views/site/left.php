<?php

use common\helpers\ArrayHelper;
use common\helpers\Url;
use common\helpers\Html;
use common\helpers\ImageHelper;
use common\helpers\AuthHelper;
use common\helpers\StringHelper;
use common\models\Store;

$store = $this->context->store;
!isset($type) && $type = 'admin';

$menus = [];
$defaultId = $firstId = 0;

foreach (Yii::$app->authSystem->userPermissionsTree as $leftPermissions) {
    if ($firstId == 0) {
        $firstId = $leftPermissions['id'];
    }

    if ($type == 'store') {
        foreach ($leftPermissions['children'] as $permission) {
            if (isset($permission['path']) && $permission['path'] && strpos(Yii::$app->request->url, $permission['path']) !== false) {
                $defaultId = $leftPermissions['id'];
                break;
            }
            if (count($permission['children']) > 0) {
                foreach ($permission['children'] as $child) {
                    if (isset($child['path']) && $child['path'] && strpos(Yii::$app->request->url, $child['path']) !== false) {
                        $defaultId = $leftPermissions['id'];
                        break;
                    }
                }
            }
        }
    }
}
$defaultId == 0 && $defaultId = $firstId;

foreach (Yii::$app->authSystem->userPermissionsTree as $leftPermissions) {
    foreach ($leftPermissions['children'] as $permission) {
        $menu = [];

        $url = Url::to([$permission['path']]);
        if (count($permission['children']) > 0) {

            $url = '#';
            foreach ($permission['children'] as $child) {
                $list = [$child['path']];
                isset($child['children']) && $list += ArrayHelper::getColumn($child['children'], 'path');
                $subMenu = [
                    'label' => Yii::t('permission', $child['name']),
                    'icon' => $child['icon'],
                    'url' => [$child['path']],
                    'active' => AuthHelper::urlMath('/' . Yii::$app->controller->route, $list) ? 'active' : '',
                    'class' => ($child['target'] || $type == 'store') ? '' : 'J_menuItem',
                    'target' => $child['target'] ? '_blank' : '_self',
                ];
                $menu['items'][] = $subMenu;
            }
        }

        $class = ' fbLeftMenuCat fbLeftMenuCat-' . $leftPermissions['id'];
        if ($leftPermissions['id'] != $defaultId) {
            $class .= ' hidden';
        } else {
            $class .= ' isDefaultMenu';
        }

        $menu += [
            'label' => Yii::t('permission', $permission['name']),
            'icon' => $permission['icon'],
            'url' => $url,
            'class' => $class,
        ];
        array_push($menus, $menu);
    }
}

if ($this->context->isStoreOwner() || $this->context->isAdmin()) {
    $subMenu = [
        ['label' => Yii::t('permission', '在线充值'), 'icon' => 'fas fa-credit-card', 'url' => ['/base/recharge/new'], 'class' => 'nav-link ' . ($type != 'store' ? 'J_menuItem' : '')],
        ['label' => Yii::t('permission', '充值列表'), 'icon' => 'fas far fa-list-alt', 'url' => ['/base/recharge/index'], 'class' => 'nav-link ' . ($type != 'store' ? 'J_menuItem' : '')],
        ['label' => Yii::t('permission', '资金记录'), 'icon' => 'fas far fa-list', 'url' => ['/base/fund-log/index'], 'class' => 'nav-link ' . ($type != 'store' ? 'J_menuItem' : '')],
        ['label' => Yii::t('permission', '发票索取'), 'icon' => 'fas fas fa-receipt', 'url' => ['/base/invoice/edit'], 'class' => 'nav-link ' . ($type != 'store' ? 'J_menuItem' : '')],
        ['label' => Yii::t('permission', '发票列表'), 'icon' => 'fas far fa-copy', 'url' => ['/base/invoice/index'], 'class' => 'nav-link ' . ($type != 'store' ? 'J_menuItem' : '')],
    ];
    array_push($menus, ['label' => Yii::t('permission', '财务管理'), 'icon' => 'fas fa-dollar-sign', 'url' => '#', 'class' => '', 'items' => $subMenu]);
}

array_push($menus, ['label' => Yii::t('permission', '帮助系统'), 'icon' => 'fas fa-question-circle', 'url' => '/help/' . Yii::$app->language . '/', 'target' => '_blank']);
array_push($menus, ['label' => Yii::t('permission', '消息列表'), 'icon' => 'fas fa-comments', 'url' => ['/base/msg/index'], 'class' => 'leftMessage ' . ($type != 'store' ? 'J_menuItem' : '')]);

if (Yii::$app->authSystem->isAdmin()) { //管理员显示
    if (YII_ENV_DEV) {
        $subMenu = [
            ['label' => Yii::t('permission', 'Gii Crud'), 'icon' => 'fas fa-file-signature', 'url' => ['/gii/crud'], 'class' => 'nav-link', 'target' => '_blank'],
            ['label' => Yii::t('permission', 'Gii Model'), 'icon' => 'fas fa-download', 'url' => ['/gii/model'], 'class' => 'nav-link', 'target' => '_blank'],
            ['label' => Yii::t('permission', 'Gii All'), 'icon' => 'fas fa-code', 'url' => ['/gii'], 'class' => 'nav-link', 'target' => '_blank'],
        ];
        array_push($menus, ['label' => Yii::t('permission', 'Gii'), 'icon' => 'fas fa-code', 'url' => '#', 'class' => '', 'items' => $subMenu]);

        $subMenu = [
            ['label' => Yii::t('permission', '二维码'), 'icon' => 'fas fa-puzzle-piece', 'url' => ['/tool/qr'], 'class' => 'nav-link J_menuItem', 'target' => '_self'],
            ['label' => Yii::t('permission', 'Crud'), 'icon' => 'fas fa-puzzle-piece', 'url' => ['/tool/crud'], 'class' => 'nav-link J_menuItem', 'target' => '_self'],
            ['label' => Yii::t('permission', 'Crud Modal'), 'icon' => 'fas fa-puzzle-piece', 'url' => ['/tool/crud-modal'], 'class' => 'nav-link J_menuItem', 'target' => '_self'],
            ['label' => Yii::t('permission', '树形表格'), 'icon' => 'fas fa-puzzle-piece', 'url' => ['/tool/tree'], 'class' => 'nav-link J_menuItem', 'target' => '_self'],
            ['label' => Yii::t('permission', 'Mongodb Crud'), 'icon' => 'fas fa-puzzle-piece', 'url' => ['/tool/mongodb-crud'], 'class' => 'nav-link J_menuItem', 'target' => '_self'],
            ['label' => Yii::t('permission', 'Redis Crud'), 'icon' => 'fas fa-puzzle-piece', 'url' => ['/tool/redis-crud'], 'class' => 'nav-link J_menuItem', 'target' => '_self'],
            ['label' => Yii::t('permission', 'Elasticsearch Crud'), 'icon' => 'fas fa-puzzle-piece', 'url' => ['/tool/elasticsearch-crud'], 'class' => 'nav-link J_menuItem', 'target' => '_self'],
            ['label' => Yii::t('permission', 'Debug'), 'icon' => 'fas fa-bug', 'url' => ['/debug'], 'class' => 'nav-link', 'target' => '_blank'],
            ['label' => Yii::t('permission', '接口文档'), 'icon' => 'fas fa-file-alt', 'url' => ['/swagger/index'], 'class' => 'nav-link', 'target' => '_blank'],
        ];
        array_push($menus, ['label' => Yii::t('permission', 'Tools'), 'icon' => 'fas fa-puzzle-piece', 'url' => '#', 'class' => '', 'items' => $subMenu]);

        array_push($menus, ['label' => Yii::t('permission', 'Funboot开发指南'), 'icon' => 'fa fa-book', 'url' => 'https://github.com/funson86/funboot/tree/master/docs/guide-zh-CN', 'target' => '_blank']);
        array_push($menus, ['label' => Yii::t('permission', 'QQ开发交流群'), 'icon' => 'fab fa-qq', 'url' => 'https://qm.qq.com/cgi-bin/qm/qr?k=jJwNMMAkEelzRPmHrSc-WXS5jrwVH-3x&jump_from=webapi', 'target' => '_blank']);
    }
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Yii::$app->homeUrl ?>" class="brand-link">
        <img src="<?= $store->settings['website_logo'] ?: ImageHelper::getLogo() ?>" alt="<?= $store->settings['website_name'] ?: $store->name ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= substr(($store->settings['website_name'] ?: $store->name), 0, 20) ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= \common\helpers\ImageHelper::getAvatar() ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?= ($type == 'store' && $this->context->isStoreOwner()) ? Url::to(['/base/fund-log/index']) : 'javascript:;' ?>" class="d-block"><?= StringHelper::fixLength(Yii::$app->user->identity->username, 15) ?> (<?= ($store->settings['payment_currency'] ?? Store::getCurrencyShortName(Yii::$app->formatter->currencyCode, true, true)) . $store->fund ?>)</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= \common\widgets\adminlte\Menu::widget([
                'items' => $menus
            ]) ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
