<?php

namespace common\widgets\jstree\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package common\widgets\jstree\assets
 * @author funson86 <funson86@gmail.com>
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@common/widgets/jstree/resources/';

    public $css = [
        'themes/default-funboot/style.min.css',
    ];

    public $js = [
        'jstree.min.js',
    ];
}