<?php

namespace common\components\ueditor\assets;

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
    public $sourcePath = '@common/components/ueditor/resources/';

    public $css = [
    ];

    public $js = [
        'ueditor.config.js',
        'ueditor.all.min.js',
    ];

    public $publishOptions = [
        'except' => [
            'php/',
            'index.html',
            '.gitignore'
        ]
    ];
}