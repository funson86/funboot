<?php

namespace common\widgets\adminlte;

use yii\web\AssetBundle;

/**
 * Class HeadJsAsset
 * @package common\widgets\adminlte
 * @author funson86 <funson86@gmail.com>
 */
class HeadJsAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/adminlte/resources/';

    public $js = [
        'plugins/jquery/jquery.min.js',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
