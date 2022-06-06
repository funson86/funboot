<?php

namespace common\components\assets;

/**
 * https://jqueryniceselect.hernansartorio.com/
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class JqueryNiceSelectAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/jquery-nice-select';

    public $css = [
        'css/nice-select.css',
    ];

    public $js = [
        'js/jquery.nice-select.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
