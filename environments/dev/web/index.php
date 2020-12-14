<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../common/config/bootstrap.php';
require __DIR__ . '/../frontend/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../common/config/main.php',
    require __DIR__ . '/../common/config/main-local.php',
    require __DIR__ . '/../frontend/config/main.php',
    require __DIR__ . '/../frontend/config/main-local.php'
);

$host = file_exists(__DIR__ . '/../frontend/runtime/host.php') ? require __DIR__ . '/../frontend/runtime/host.php' : [];
$config['defaultRoute'] = $host[$_SERVER['SERVER_NAME']] ?? 'site';

(new yii\web\Application($config))->run();
