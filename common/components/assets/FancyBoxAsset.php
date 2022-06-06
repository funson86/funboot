<?php

namespace common\components\assets;

/**
 * <script src="https://unpkg.com/jquery@3.5.1/dist/jquery.min.js"></script>
 * Class FancyBoxAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class FancyBoxAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/fancy-box';

    public $css = [
        'dist/jquery.fancybox.min.css',
    ];

    public $js = [
        'dist/jquery.fancybox.min.js',
    ];
}
