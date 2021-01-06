<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'base' => [
            'class' => 'backend\modules\base\Module',
        ],
        'pay' => [
            'class' => 'backend\modules\pay\Module',
        ],
        'cms' => [
            'class' => 'backend\modules\cms\Module',
        ],
        'mall' => [
            'class' => 'backend\modules\mall\Module',
        ],
        'school' => [
            'class' => 'backend\modules\school\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                'message/index/<status:\d+>' => 'message/index',
                'base/message-send/index/<messageId:\d+>' => 'base/message-send/index',
                'base/message-send/index' => 'base/message-send/index',
                'base/log/index/<type:\d+>' => 'base/log/index',
                '<modules:\w+>/<controller:\w+>/<id:\d+>' => '<modules>/<controller>/view',
                '<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<modules>/<controller>/<action>',
                '<modules:\w+>/<controller:\w+>/<action:\w+>'=>'<modules>/<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                //'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function (\yii\base\Event $event) {
                Yii::$app->logSystem->error($event->sender);
            },
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
        'swagger' => 'common\components\swagger\SwaggerController', // SwaggerApi接口
    ],

    'params' => $params,
];
