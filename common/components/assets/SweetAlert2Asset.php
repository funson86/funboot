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
    public $css = [
        'https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
