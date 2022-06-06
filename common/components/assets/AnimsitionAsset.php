<?php

namespace common\components\assets;

/**
 * 页面切换动画 JS有问题会导致显示异常，复杂场景慎用
 * <script src="https://unpkg.com/jquery@3.5.1/dist/jquery.min.js"></script>
 * Class AnimsitionAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class AnimsitionAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/animsition';

    public $css = [
        'dist/css/animsition.min.css',
    ];

    public $js = [
        'dist/js/animsition.min.js',
    ];
}
