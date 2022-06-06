<?php

namespace common\components\assets;

/**
 * 滑动
 * https://github.com/OwlCarousel2/OwlCarousel2
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class OwlCarouselAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/owl-carousel';

    public $css = [
        'dist/assets/owl.carousel.min.css',
    ];

    public $js = [
        'dist/owl.carousel.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
