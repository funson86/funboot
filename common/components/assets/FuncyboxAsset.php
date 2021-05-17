<?php

namespace common\components\assets;

/**
 * <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
 * Class FuncyboxAsset
 * @package common\widgets\echarts
 * @author funson86 <funson86@gmail.com>
 */
class FuncyboxAsset extends \yii\web\AssetBundle
{
    public $css = [
        'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js',
    ];
}
