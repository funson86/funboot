<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * Main frontend application asset bundle.
 */
class PayLandingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Lato',
        'https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900',
        'https://fonts.googleapis.com/css?family=Muli',
        '/resources/pay/css/funpay.css',
    ];
    public $js = [
        '/resources/js/jquery.easing.min.js',
        '/resources/pay/js/funpay.js',
    ];

    public $depends = [
        'common\widgets\adminlte\Bootstrap4Asset',
        'common\widgets\adminlte\Bootstrap4PluginAsset',
        'common\widgets\adminlte\HeadJsAsset',
        'common\widgets\adminlte\FontAwesomeAsset',
    ];
}
