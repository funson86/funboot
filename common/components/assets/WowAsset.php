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
    public $js = [
        'https://unpkg.com/wow.js@1.2.2/dist/wow.min.js',
    ];
}
