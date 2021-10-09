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
    ];

    public $js = [
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
        'common\widgets\funboot\assets\FunbootBootstrapFixAsset',
        'common\components\assets\Bootstrap4Asset',
        'common\components\assets\CookieBarAsset',
        'common\components\assets\LazyloadAsset',
        'common\components\assets\FlagIconCssAsset',
        'common\components\assets\FancyBoxAsset',
        'common\components\assets\FontAwesomeAsset',
        'common\components\assets\AnimateAsset',
        'common\components\assets\WowAsset',
    ];
}
