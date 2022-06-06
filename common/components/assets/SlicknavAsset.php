<?php

namespace common\components\assets;

/**
 * 折叠栏目
 * https://github.com/OwlCarousel2/OwlCarousel2
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class SlicknavAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/slicknav';

    public $css = [
        'dist/slicknav.min.css',
    ];

    public $js = [
        'dist/jquery.slicknav.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
