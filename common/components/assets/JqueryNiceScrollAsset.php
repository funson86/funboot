<?php

namespace common\components\assets;

/**
 * https://nicescroll.areaaperta.com/
 * https://github.com/inuyaksa/jquery.nicescroll
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class JqueryNiceScrollAsset extends \yii\web\AssetBundle
{
    public $js = [
        'https://unpkg.com/jquery.nicescroll@3.7.6/jquery.nicescroll.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
