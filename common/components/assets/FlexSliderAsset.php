<?php

namespace common\components\assets;

/**
 * 配合animate滑动动画
 * https://github.com/woocommerce/FlexSlider
 * https://woocommerce.com/flexslider/
 * Class FlexSliderAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class FlexSliderAsset extends \yii\web\AssetBundle
{
    public $css = [
        'https://unpkg.com/flexslider@2.7.2/flexslider.css',
    ];

    public $js = [
        'https://unpkg.com/flexslider@2.7.2/jquery.flexslider-min.js',
    ];
}
