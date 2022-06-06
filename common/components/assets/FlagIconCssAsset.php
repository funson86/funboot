<?php

namespace common\components\assets;

/**
 * Fontawesome
 * Class FlagIconCssAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class FlagIconCssAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/flag-icon-css';

    public $css = [
        'css/flag-icon.min.css',
    ];
}
