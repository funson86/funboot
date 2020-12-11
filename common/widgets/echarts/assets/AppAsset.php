<?php

namespace common\widgets\echarts\assets;

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
    public $sourcePath = '@common/widgets/echarts/resources/';

    public $css = [
    ];

    public $js = [
        'echarts.min.js',
        'extension/bmap.js',
        'theme/macarons.js',
        'theme/dark.js',
        'theme/fresh-cut.js',
        'theme/green.js',
    ];
}
