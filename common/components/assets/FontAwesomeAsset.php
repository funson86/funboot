<?php

namespace common\components\assets;

/**
 * Fontawesome
 * Class FontAwesomeAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class FontAwesomeAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/font-awesome';

    public $css = [
        'css/font-awesome.min.css',
    ];
}
