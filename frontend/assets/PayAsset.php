<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * Main frontend application asset bundle.
 */
class PayAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/resources/pay/css/funpay.css',
    ];

    public $js = [
    ];

    public $depends = [
        'common\widgets\adminlte\AdminltePayAsset',
        'common\widgets\funboot\assets\AppAsset',
    ];
}
