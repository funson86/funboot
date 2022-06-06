<?php

namespace common\components\assets;

/**
 * 优雅的弹出框
 * https://sweetalert2.github.io/
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class SweetAlert2Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/sweetalert2';

    public $css = [
        'dist/sweetalert2.min.css',
    ];

    public $js = [
        'dist/sweetalert2.all.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
