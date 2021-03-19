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
        'mall' => [
            'class' => 'frontend\modules\mall\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf',
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
                    'logFile' => '@runtime/logs/' . date('Ym/d') . '.log',
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
                '<store_id:\d+>' => 'site/index', // 根据项目情况进行匹配
                //'product/<id:\d+>' => 'mall/product/view', // url 优化
                //'product/<action:\w+>/<id:\d+>' => 'mall/product/<action>',
                //'product/<action:\w+>' => 'mall/product/<action>',
                '<modules:\w+>/<controller:\w+>/<id:\d+>' => '<modules>/<controller>/view',
                '<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<modules>/<controller>/<action>',
                '<modules:\w+>/<controller:\w+>/<action:\w+>' => '<modules>/<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'assetManager' => [
            // 'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [],
                    'sourcePath' => null,
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],  // 去除 bootstrap.css
                    'sourcePath' => null,
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [],  // 去除 bootstrap.js
                    'sourcePath' => null,
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'css' => [],  // 去除 bootstrap.css
                    'sourcePath' => null,
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'js' => [],  // 去除 bootstrap.js
                    'sourcePath' => null,
                ],
            ],
        ],
    ],
    'params' => $params,
];
