<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MallAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];

    public $js = [
    ];

    public $depends = [
        'common\widgets\adminlte\HeadJsAsset',
        'common\widgets\adminlte\FlagIconAsset',
        'common\components\assets\FontAwesomeAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
