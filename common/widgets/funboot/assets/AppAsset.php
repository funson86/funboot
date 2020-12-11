<?php

namespace common\widgets\funboot\assets;

/**
 * Class AppAsset
 * @package common\widgets\echarts
 * @author funson86 <funson86@gmail.com>
 */
class AppAsset extends \yii\web\AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@common/widgets/funboot/resources/';

    public $css = [
        'fancybox/jquery.fancybox.min.css',
        'css/funboot.bootstrap.css',
        'css/funboot.widget.css',
        'css/funboot.css',
    ];

    public $js = [
        'layer/layer.js',
        'js/contabs.js',
        'js/template-web.js',
        'fancybox/jquery.fancybox.min.js',
        'js/funboot.widget.js',
        'js/funboot.js',
    ];
}
