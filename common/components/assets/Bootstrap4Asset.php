<?php

namespace common\components\assets;

/**
 * 页面元素动画
 * Class Bootstrap4Asset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class Bootstrap4Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/bootstrap4';

    public $css = [
        'dist/css/bootstrap.min.css',
    ];

    public $js = [
        'dist/js/bootstrap.bundle.min.js',
    ];
}
