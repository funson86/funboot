<?php

namespace common\components\assets;

/**
 * Head
 * Class JqueryAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class JqueryAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/jquery';

    public $js = [
        'jquery-3.5.1.min.js',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
