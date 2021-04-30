<?php

namespace common\widgets\adminlte;

use yii\web\AssetBundle;

/**
 * Class AdminlteAsset
 * @package common\widgets\adminlte
 * @author funson86 <funson86@gmail.com>
 */
class FlagIconAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/adminlte/resources/';

    public $css = [
        'plugins/flag-icon-css/css/flag-icon.min.css',
    ];

    public $js = [
    ];

    public $depends = [
    ];
}