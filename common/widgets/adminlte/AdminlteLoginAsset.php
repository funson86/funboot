<?php

namespace common\widgets\adminlte;

use yii\web\AssetBundle;

/**
 * Class AdminlteAsset
 * @package common\widgets\adminlte
 * @author funson86 <funson86@gmail.com>
 */
class AdminlteLoginAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/adminlte/resources/';

    public $css = [
        'plugins/fontawesome-free/css/all.min.css',
        'plugins/ionicons/ionicons.min.css',
        'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'dist/css/adminlte.min.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
    ];

    public $js = [
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
        'dist/js/adminlte.min.js',
    ];

    public $depends = [
        'common\widgets\adminlte\HeadJsAsset',
    ];
}