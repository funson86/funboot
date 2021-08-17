<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'oauth' => [
            'class' => 'api\modules\oauth\Module',
        ],
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module'
        ],
        'v2' => [
            'basePath' => '@api/modules/v2',
            'class' => 'api\modules\v2\Module'
        ],
        'school' => [
            'basePath' => '@api/modules/school',
            'class' => 'api\modules\school\Module'
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'api\models\User',
             'enableAutoLogin' => true,
             'enableSession' => false,// 显示一个HTTP 403 错误, 不是跳转到登录界面
            'loginUrl' => null,
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
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'api\components\response\JsonResponseFormatterSystem',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
            'on beforeSend' => function ($event) {
                /* $response = $event->sender;
                $data = $response->data;
                $response->data = [
                    'code' => $response->statusCode,
                    'msg' => $data['msg'] ?? null
                ];
                (!isset($response->data['msg']) || !$response->data['msg']) && $response->data['msg'] = $data['message'] ?? '';
                unset($data['code'], $data['msg']);
                $response->data['data'] = $data;*/
            },
        ],
        'responseSystem' => [
            'class' => 'api\components\response\ResponseSystem',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // 'enableStrictParsing' => true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'student',
                        'v1/user',
                    ]
                ],
                '<modules:\w+>/<controller:\w+>/<action:\w+>'=>'<modules>/<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'as cors' => [
        'class' => \yii\filters\Cors::class,
    ],
    'params' => $params,
];
