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
    public $sourcePath = '@common/components/assets/resources/toastr';

    public $css = [
        'build/toastr.min.css',
    ];

    public $js = [
        'build/toastr.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
