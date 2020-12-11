<?php

namespace common\widgets\adminlte;

use yii\web\AssetBundle;

/**
 * Class HeadJsAsset
 * @package common\widgets\adminlte
 * @author funson86 <funson86@gmail.com>
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/adminlte/resources/';

    public $css = [
        'plugins/fontawesome-free/css/all.min.css',
    ];
}
