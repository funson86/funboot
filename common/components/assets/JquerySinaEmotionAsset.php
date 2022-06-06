<?php

namespace common\components\assets;

/**
 * https://github.com/Lanfei/jquery-sina-emotion/
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class JquerySinaEmotionAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/jquery-sina-emotion';

    public $css = [
        'dist/jquery-sina-emotion.min.css',
    ];

    public $js = [
        'dist/jquery-sina-emotion.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
