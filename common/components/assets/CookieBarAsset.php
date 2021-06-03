<?php

namespace common\components\assets;

/**
 * 延迟加载
 * Class AnimateAsset
 * @package common\widgets\echarts
 * @author funson86 <funson86@gmail.com>
 */
class CookieBarAsset extends \yii\web\AssetBundle
{
    public $css = [
        '/resources/css/jquery.cookiebar.css',
    ];

    public $js = [
        '/resources/js/jquery.cookiebar.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
