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
    ];

    public $js = [
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
        'common\components\assets\Bootstrap4Asset',
        'common\components\assets\CookieBarAsset',
        'common\components\assets\FlagIconCssAsset',
        'common\components\assets\JquerySinaEmotionAsset',
    ];
}
