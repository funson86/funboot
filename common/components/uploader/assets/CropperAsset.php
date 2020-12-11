<?php

namespace common\components\uploader\assets;

/**
 * Class CropperAsset
 * @package common\components\uploader\assets
 * @author funson86 <funson86@gmail.com>
 */
class CropperAsset extends \yii\web\AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@common/components/uploader/resources/';

    public $css = [
        'cropper/cropper.min.css'
    ];

    public $js = [
        'cropper/cropper.min.js',
    ];

    public $depends = [
    ];
}