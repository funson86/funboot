<?php

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * Class HeadJsAsset
 * @package common\widgets\adminlte
 * @author funson86 <funson86@gmail.com>
 */
class I18nAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public function init()
    {
        array_push($this->js, 'resources/js/i18n/' . Yii::$app->language . '.js');
        parent::init();
    }
}
