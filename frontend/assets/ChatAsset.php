<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * Main frontend application asset bundle.
 */
class ChatAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdn.jsdelivr.net/npm/jquery-sina-emotion@4.1.0/dist/jquery-sina-emotion.min.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/jquery-sina-emotion@4.1.0/dist/jquery-sina-emotion.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
        'common\components\assets\Bootstrap4Asset',
        'common\components\assets\CookieBarAsset',
        'common\components\assets\FlagIconCssAsset',
    ];
}
