<?php

namespace common\components\assets;

/**
 * https://jqueryui.com/
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class JqueryUiAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/jquery-ui-dist';

    public $css = [
        'jquery-ui.min.css',
    ];

    public $js = [
        'jquery-ui.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}
