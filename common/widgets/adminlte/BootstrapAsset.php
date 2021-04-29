<?php

namespace common\widgets\adminlte;

use yii\web\AssetBundle;

/**
 * Class Bootstrap4Asset
 * @package common\widgets\adminlte
 * @author funson86 <funson86@gmail.com>
 */
class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/adminlte/resources/';

    public $css = [
        'plugins/bootstrap/css/bootstrap.min.css',
    ];
}
