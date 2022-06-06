<?php

namespace common\components\assets;

/**
 * 延迟加载
 * Class CookieBarAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class CookieBarAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/cookie-bar';

    public $css = [
        'css/jquery.cookiebar.css',
    ];

    public $js = [
        'js/jquery.cookiebar.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
