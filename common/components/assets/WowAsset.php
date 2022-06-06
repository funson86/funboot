<?php

namespace common\components\assets;

/**
 * 配合animate滑动动画
 * Class WowAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class WowAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/wow';

    public $js = [
        'dist/wow.min.js',
    ];
}
