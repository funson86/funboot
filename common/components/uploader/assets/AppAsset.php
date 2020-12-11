<?php

namespace common\components\uploader\assets;

/**
 * Class AppAsset
 * @package common\components\uploader\assets
 * @author funson86 <funson86@gmail.com>
 */
class AppAsset extends \yii\web\AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@common/components/uploader/resources/';

    public $css = [
    ];

    public $js = [
        'sortable/Sortable.min.js',
        'webuploader/webuploader.min.js',
    ];

    public $depends = [
        'common\components\uploader\assets\CropperAsset'
    ];
}