<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'en',
    // 'sourceLanguage' => 'zh-cn',
    // 'timeZone' => 'Asia/Shanghai',
    'timeZone' => 'Europe/London',
    'bootstrap' => ['log', 'queue'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@console/runtime/cache',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/funboot',
        ],
        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'path' => '@console/runtime/queue',
        ],
        'storeSystem' => [
            'class' => 'common\components\base\StoreSystem',
        ],
        'logSystem' => [
            'class' => 'common\components\base\LogSystem',
            'queue' => false,//true, // 是否通过队列方式存数据库
            'driver' => 'mysql', //'mongodb', // 存储方式，mysql数据库或mongodb数据库
            'levels' => ['error', 'warning'], // 记录日志等级error warning info trace
            'ignoreCodes' => [404], // 忽略错误码
        ],
        'authSystem' => [
            'class' => 'common\components\base\AuthSystem',
            'superAdminUsernames' => ['admin', 'superadmin'], //拥有所有权限的用户名
            'maxAdminRoleId' => 49, //管理员最大角色ID
            'maxStoreRoleId' => 99, //能进入后台用户最大角色ID
        ],
        'cacheSystem' => [
            'class' => 'common\components\base\CacheSystem',
        ],
        'dictSystem' => [
            'class' => 'common\components\base\DictSystem',
        ],
        'messageSystem' => [
            'class' => 'common\components\base\MessageSystem',
            'queue' => false,//true, // 是否通过队列方式存数据库
        ],
        'settingSystem' => [
            'class' => 'common\components\base\SettingSystem',
        ],
        'mailSystem' => [
            'class' => 'common\components\base\MailSystem',
            'queue' => true, //false, // 默认通过队列方式发送邮件
        ],
        'cacheMall' => [
            'class' => 'common\components\mall\CacheMall',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                //'<modules:\w+>/<controller:\w+>/<id:\d+>' => '<modules>/<controller>/view',
                //'<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<modules>/<controller>/<action>',
                '<modules:\w+>/<controller:\w+>/<action:\w+>'=>'<modules>/<controller>/<action>',
                //'<controller:\w+>/<id:\d+>' => '<controller>/view',
                //'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php', // 通用
                        'cons' => 'cons.php', // 常量，每个翻译目录都要有，否则常量名很难看
                        'permission' => 'permission.php', // 菜单，默认中文，其他语言目录需要有
                        'setting' => 'setting.php', // 设置，默认中文，其他语言目录需要有
                        'frontend' => 'frontend.php', // frontend自定义配置
                        'backend' => 'backend.php', // backend自定义配置
                        'api' => 'api.php', // api自定义配置
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.zoho.com.cn',  //每种邮箱的host配置不一样
                'username' => 'service@wewok.co.uk',
                'password' => 'Abcd7598',
                'port' => '587',
                'encryption' => 'tls', // tls  ssl
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=> ['service@wewok.co.uk' => 'service_wewok'],
            ],
        ],
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
    ],
];
