<?php

namespace common\components\assets;

/**
 * 延迟加载
 * Class AnimateAsset
 * @package common\widgets\echarts
 * @author funson86 <funson86@gmail.com>
 */
class LazyloadAsset extends \yii\web\AssetBundle
{
    public $js = [
        'https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js',
    ];
}
