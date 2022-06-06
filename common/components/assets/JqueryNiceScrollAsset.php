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
    public $sourcePath = '@common/components/assets/resources/jquery-nice-scroll';

    public $js = [
        'dist/jquery.nicescroll.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
