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
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'pay' => [
            'class' => 'frontend\modules\pay\Module',
        ],
        'cms' => [
            'class' => 'frontend\modules\cms\Module',
        ],
        'bbs' => [
            'class' => 'frontend\modules\bbs\Module',
        ],
        'mall' => [
            'class' => 'frontend\modules\mall\Module',
        ],
        'wechat' => [
            'class' => 'frontend\modules\wechat\Module',
        ],
        'chat' => [
            'class' => 'frontend\modules\chat\Module',
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
                'sid-<store_id:\d+>' => 'mall/default/index', // 根据项目情况进行匹配，可以自定义前缀匹配
                'site-<store_code:[\w-]+>' => 'site/index', // 根据项目情况进行匹配，可以自定义前缀匹配
                'store-<store_code:[\w-]+>' => 'mall/default/index', // 根据项目情况进行匹配，可以自定义前缀匹配
                'mall-<store_code:[\w-]+>' => 'mall/default/index', // 根据项目情况进行匹配，可以自定义前缀匹配
                'cms-<store_code:[\w-]+>' => 'cms/default/index', // 根据项目情况进行匹配，可以自定义前缀匹配
                'bbs-<store_code:[\w-]+>' => 'bbs/default/index', // 根据项目情况进行匹配，可以自定义前缀匹配

                // pay url 优化
                'pay/<action:[\w-]+>' => 'pay/default/<action>',

                // cms url 优化
                'list/<id:\d+>' => 'cms/default/list',
                'menu/<id:\d+>' => 'cms/default/menu',
                'page/<id:\d+>' => 'cms/default/page',
                'cms/search' => 'cms/default/search',

                // mall url 优化
                'category-<seo_url:[\w-]+>' => 'mall/category/view',
                'product-<seo_url:[\w-]+>' => 'mall/product/view',
                //'product/<id:\d+>' => 'mall/product/view', // url 优化
                //'product/<action:[\w-]+>/<id:\d+>' => 'mall/product/<action>',
                //'product/<action:[\w-]+>' => 'mall/product/<action>',

                // bbs url 优化
                'node/<id:\d+>' => 'bbs/default/index',
                'bbs' => 'bbs/default/index',
                'bbs/tag' => 'bbs/default/tag',
                't/<id:\d+>' => 'bbs/topic/view',
                'topic/<id:\d+>' => 'bbs/topic/view',
                'topic/<action:[\w-]+>/<id:\d+>' => 'bbs/topic/<action>',
                'topic/<action:[\w-]+>' => 'bbs/topic/<action>',
                'bbs/user-action/<action:\d+>/<type:\d+>/<id:\d+>' => 'bbs/user-action/index',
                'bbs/<alias:login|logout|signup|request-password-reset|reset-password|verify-email|resend-verification-email|tag|yellow-page>' => 'bbs/default/<alias>',

                '<modules:[\w-]+>/<controller:[\w-]+>/<id:\d+>' => '<modules>/<controller>/view',
                '<modules:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<modules>/<controller>/<action>',
                '<modules:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' => '<modules>/<controller>/<action>',
                '<controller:[\w-]+>/<id:\d+>' => '<controller>/view',
                '<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',
                '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
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

    'controllerMap' => [
        'file' => 'common\components\uploader\FileController', // 文件上传公共控制器
        'ueditor' => 'common\components\ueditor\UeditorController', // 百度编辑器
    ],

    'params' => $params,
];
