<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppLoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'resources/css/login.css',
    ];
    public $js = [
        'resources/js/site.js',
        'resources/js/login.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'common\widgets\funboot\assets\AppAsset',
        'backend\assets\I18nAsset',
    ];
}
