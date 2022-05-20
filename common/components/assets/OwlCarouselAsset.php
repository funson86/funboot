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
    public $css = [
        'https://unpkg.com/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css',
    ];

    public $js = [
        'https://unpkg.com/owl.carousel@2.3.4/dist/owl.carousel.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
