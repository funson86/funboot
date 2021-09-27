<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/resources/css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'common\components\assets\JqueryAsset',
        'common\components\assets\LazyloadAsset',
        'common\components\assets\Bootstrap4Asset',
        'common\widgets\funboot\assets\FunbootBootstrapFixAsset',
        'common\components\assets\FontAwesomeAsset',
        'common\components\assets\AnimateAsset',
        'common\components\assets\FancyBoxAsset',
        'common\components\assets\WowAsset',
    ];
}
