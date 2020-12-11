<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'en',
    'bootstrap' => ['log'],
    //'defaultRoute' => 'pay', // 默认路由 cms mall 
    //'defaultRoute' => 'cms', // 默认路由 cms mall
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'pay' => [
            'class' => 'frontend\modules\pay\Module',
        ],
        'cms' => [
            'class' => 'frontend\modules\cms\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'cms/default/list/<id:\d+>' => 'cms/default/list',
                'list/<id:\d+>' => 'cms/default/list',
                'list' => 'api/getusers',
                'getusers' => 'api/getusers',
                'getorders' => 'api/getorders',
                'getorderproducts' => 'api/getorderproducts',
            ],
        ],
        'assetManager' => [
            // 'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [],
                    'sourcePath' => null,
                ],
            ],
        ],
    ],
    'params' => $params,
];
