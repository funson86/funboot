<?php

namespace common\components\assets;

/**
 * IcheckAsset
 * Class AnimateAsset
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class IcheckAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/components/assets/resources/icheck';

    public $js = [
        'icheck.min.js',
    ];
}
