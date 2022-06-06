<?php

namespace common\components\assets;

/**
 * 页面元素动画
 * Class AnimateAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class AnimateAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/animate';

    public $css = [
        'animate.min.css',
    ];
}
