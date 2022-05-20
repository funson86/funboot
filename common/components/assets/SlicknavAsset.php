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
    public $css = [
        'https://unpkg.com/slicknav@1.0.8/dist/slicknav.min.css',
    ];

    public $js = [
        'https://unpkg.com/slicknav@1.0.8/dist/jquery.slicknav.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
