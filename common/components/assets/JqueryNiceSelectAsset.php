<?php

namespace common\components\assets;

/**
 * https://jqueryniceselect.hernansartorio.com/
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class JqueryNiceSelectAsset extends \yii\web\AssetBundle
{
    public $css = [
        'https://cdn.jsdelivr.net/npm/jquery-nice-select@1.1.0/css/nice-select.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/jquery-nice-select@1.1.0/js/jquery.nice-select.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
