<?php

namespace common\components\assets;

/**
 * 边栏固定
 * Class TheiaStickySidebarAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class TheiaStickySidebarAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/theia-sticky-sidebar';

    public $js = [
        'dist/ResizeSensor.min.js',
        'dist/theia-sticky-sidebar.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
