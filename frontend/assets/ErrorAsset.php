<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Error frontend application asset bundle.
 */
class ErrorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'common\components\assets\Bootstrap4Asset',
    ];
}
