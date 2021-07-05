<?php

namespace common\components\assets;

/**
 * 页面切换动画 JS有问题会导致显示异常，复杂场景慎用
 * <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
 * Class AnimsitionAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class AnimsitionAsset extends \yii\web\AssetBundle
{
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/css/animsition.min.css',
    ];

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/js/animsition.min.js',
    ];
}
