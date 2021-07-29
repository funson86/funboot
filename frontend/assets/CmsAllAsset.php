<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CmsAllAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'resources/css/cms_base.css',
    ];

    public $js = [
        'resources/js/cms_base.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
        'common\components\assets\Bootstrap4Asset',
        'common\components\assets\CookieBarAsset',
        'common\components\assets\LazyloadAsset',
        'common\components\assets\FlagIconCssAsset',
        'common\components\assets\FancyBoxAsset',
        'common\components\assets\FontAwesomeAsset',
        'common\components\assets\AnimateAsset',
        'common\components\assets\WowAsset',
        'common\components\assets\FlexSliderAsset',
    ];
}
