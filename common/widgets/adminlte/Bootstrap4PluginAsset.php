<?php

namespace common\widgets\adminlte;

use yii\web\AssetBundle;

/**
 * Class Bootstrap4Asset
 * @package common\widgets\adminlte
 * @author funson86 <funson86@gmail.com>
 */
class Bootstrap4PluginAsset extends AssetBundle
{
    public $js = [
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js',
    ];

    public $depends = [
        'yii\bootstrap4\BootstrapAsset',
    ];
}
