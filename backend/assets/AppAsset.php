<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'resources/css/site.css',
    ];
    public $js = [
        'resources/js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'common\widgets\adminlte\AdminlteAsset',
        'common\widgets\funboot\assets\AppAsset',
        'backend\assets\I18nAsset',
    ];
}
