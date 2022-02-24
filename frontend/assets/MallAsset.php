<?php

namespace frontend\assets;

use common\components\assets\SweetAlert2Asset;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MallAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css2?family=Cookie&display=swap',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap',
    ];

    public $js = [
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
        'common\components\assets\Bootstrap4Asset',
        'common\components\assets\JqueryUiAsset',
        'common\components\assets\JqueryNiceSelectAsset',
        'common\components\assets\CookieBarAsset',
        'common\components\assets\LazyloadAsset',
        'common\components\assets\FlagIconCssAsset',
        'common\components\assets\FancyBoxAsset',
        'common\components\assets\FontAwesomeAsset',
        'common\components\assets\AnimateAsset',
        'common\components\assets\WowAsset',
        'common\components\assets\OwlCarouselAsset',
        'common\components\assets\SlicknavAsset',
        'common\components\assets\SweetAlert2Asset',
    ];
}
