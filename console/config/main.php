<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class' => 'e282486518\migration\ConsoleController',
        ],
        'migrate-tool' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations/tool',
        ],
        'migrate-region' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations/region',
        ],
        'migrate-oauth' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations/oauth',
        ],
        'migrate-pay' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations/pay',
        ],
        'migrate-cms' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations/cms',
        ],
        'migrate-bbs' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations/bbs',
        ],
        'migrate-mall' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations/mall',
        ],
        'migrate-wechat' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations/wechat',
        ],
        'migrate-chat' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations/chat',
        ],
    ],
    'modules' => [
        'chat' => [
            'class' => 'console\modules\chat\Module',
        ],
    ],
    'components' => [
        'db' => [
            'class' => 'console\components\Connection',
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
    ],
    'params' => $params,
];
