<?php

namespace common\components\swagger;

/**
 * Class SwaggerAsset
 * @package backend\modules\base\controllers
 * @author funson86 <funson86@gmail.com>
 */
class SwaggerAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/swagger/swagger-ui/dist/';

    public $js = [
        'swagger-ui-bundle.js',
        'swagger-ui-standalone-preset.js',
    ];

    public $css = [
        'swagger-ui.css'
    ];

    public $depends = [];
}