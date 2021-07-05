<?php

namespace common\components\assets;

/**
 * 页面元素动画
 * Class Bootstrap4Asset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class Bootstrap4Asset extends \yii\web\AssetBundle
{
    public $css = [
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js',
    ];
}
