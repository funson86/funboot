<?php

namespace common\widgets\markdown\assets;

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
    public $sourcePath = '@common/widgets/markdown/resources/';

    public $css = [
        'css/editormd.min.css',
        'css/editormd.logo.min.css',
        'css/editormd.preview.min.css',
    ];

    public $js = [
        'editormd.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
