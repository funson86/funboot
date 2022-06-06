<?php

namespace common\widgets\adminlte;

use yii\web\AssetBundle;

/**
 * Class Bootstrap4Asset
 * @package common\widgets\adminlte
 * @author funson86 <funson86@gmail.com>
 */
class Bootstrap4Asset extends AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/bootstrap4';

    public $css = [
        'dist/css/bootstrap.min.css',
    ];
}
