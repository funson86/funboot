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
    public $sourcePath = '@common/components/assets/resources/flex-slider';

    public $css = [
        'flexslider.css',
    ];

    public $js = [
        'jquery.flexslider-min.js',
    ];
}
