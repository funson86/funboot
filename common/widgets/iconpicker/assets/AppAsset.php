<?php

namespace common\widgets\iconpicker\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package common\widgets\iconpicker\assets
 * @author funson86 <funson86@gmail.com>
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@common/widgets/iconpicker/resources/';

    public $css = [
        'css/fontawesome-iconpicker.min.css',
    ];

    public $js = [
        'js/fontawesome-iconpicker.min.js',
    ];
}