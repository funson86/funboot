<?php
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$topicActive = true;

$keyword = Yii::$app->request->get('ModelSearch')['name'] ?? '';

NavBar::begin([
//     'brandLabel' => Html::img('/images/logo.png'),
    'brandLabel' => $this->context->store->settings['website_name'] ?: $this->context->store->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-light fixed-top',
    ],
]);

$rootMenu = [];
$nodes = [];
$items = [];
foreach ($nodes as $node) {
    $item = [];
    $item['label'] = $node->name;
    $item['url'] = ['/bbs/default/index', 'id' => $node->id];
    $item['active'] = (Yii::$app->request->get('id', 0) == $node->id);

    $items[] = $item;
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => ArrayHelper::merge([
        ], ArrayHelper::merge($items, [
        ])
    ),
    'encodeLabels' => false
]);

echo '<ul class="navbar-nav mr-auto ml-3"><li class="nav-item"><form class="navbar-form navbar-left" role="search" action="/mall/default/index" method="get">
        <div class="form-group mb-0">
            <input type="text" value="' . $keyword . '" name="ModelSearch[name]" class="form-control search_input" id="navbar-search" placeholder="' . Yii::t('app', 'Search') . '..." data-placement="bottom" />
        </div>
    </form></li></ul>';

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => Yii::t('app', 'Sign up'), 'url' => ['/mall/default/signup']];
    $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/mall/default/login']];
} else {
    // 通知
    /*$menuItems[] = [
        'label' => Html::tag('i', '', ['class' => 'bi-bell-fill']) . (1 > 0 ?Html::tag('span', 1, ['class' => 'badge badge-danger']) : ''),
        'url' => ['/notice/index'],
        'options' => ['class' => 'notice-count'],
    ];*/

    // 个人中心
    $menuItems[] = [
        'label' => Html::tag('i', '', ['class' => 'fa fa-user']) . ' ' . Yii::$app->user->identity->email ?: Yii::$app->user->identity->username,
        'items' => [
            ['label' => Yii::t('app', 'Profile'), 'url' => ['/mall/user/index']],
            ['label' => Yii::t('app', 'Orders'), 'url' => ['/mall/user/order']],
            ['label' => Yii::t('app', 'Coupon'), 'url' => ['/mall/user/coupon']],
            ['label' => Yii::t('app', 'Setting'), 'url' => ['/mall/user/setting']],
            ['label' => Yii::t('app', 'Logout'), 'url' => ['/mall/default/logout'], 'linkOptions' => ['data-method' => 'post']]
        ]
    ];
}

// 语言
/*$menuItems[] = [
    'label' => Html::tag('i', '', ['class' => 'bi-globe']),
    'items' => [
        ['label' => '<i class="flag-icon flag-icon-cn mr-2"></i>' . Yii::t('app', 'Chinese'), 'url' => 'javascript:;', 'linkOptions' => ['class' => 'funboot-lang', 'data-lang' => 'cn']],
        ['label' => '<i class="flag-icon flag-icon-gb mr-2"></i>' . Yii::t('app', 'English'), 'url' => 'javascript:;', 'linkOptions' => ['class' => 'funboot-lang', 'data-lang' => 'en']],
    ]
];*/

echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items' => $menuItems,
    'activateParents' => true,
]);
NavBar::end();
