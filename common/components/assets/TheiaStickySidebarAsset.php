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
    public $js = [
        'https://unpkg.com/theia-sticky-sidebar@1.7.0/dist/ResizeSensor.js',
        'https://unpkg.com/theia-sticky-sidebar@1.7.0/dist/theia-sticky-sidebar.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
