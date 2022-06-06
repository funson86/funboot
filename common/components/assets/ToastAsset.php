<?php

namespace common\components\assets;

/**
 * 提示框
 * https://github.com/CodeSeven/toastr
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class ToastAsset extends \yii\web\AssetBundle
{
    public $css = [
        'https://unpkg.com/toastr@2.1.4/build/toastr.min.css',
    ];

    public $js = [
        'https://unpkg.com/toastr@2.1.4/build/toastr.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
