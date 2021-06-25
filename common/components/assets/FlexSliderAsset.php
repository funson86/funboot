<?php

namespace common\components\assets;

/**
 * 配合animate滑动动画
 * Class AnimateAsset
 * @package common\widgets\echarts
 * @author funson86 <funson86@gmail.com>
 */
class FlexSliderAsset extends \yii\web\AssetBundle
{
    public $css = [
        'https://cdn.jsdelivr.net/npm/flexslider@2.7.2/flexslider.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/flexslider@2.7.2/jquery.flexslider-min.js',
    ];
}
