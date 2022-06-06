<?php

namespace common\components\assets;

/**
 * 延迟加载
 * Class LazyloadAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class LazyloadAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/lazyload';

    public $js = [
        'lazyload.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
