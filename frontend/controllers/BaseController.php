<?php

namespace frontend\controllers;

use common\helpers\IdHelper;
use yii\base\Model;
use common\models\Store;
use Yii;
use yii\helpers\Json;

/**
 * Class BaseController
 * @package frontend\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends \common\components\controller\BaseController
{
    public $prefixStatic;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            // 前台强制为指定语言
            strlen($this->store->lang_frontend_default) > 0 && Yii::$app->language = $this->store->lang_frontend_default;
            return true;
        }
        return false;
    }

    /**
     * 处理通用数据
     * @param $model
     * @return array
     */
    protected function commonData($model)
    {
        $settings = $this->getSettings();

        $commonData = [];

        return $commonData;
    }

    /**
     * @return \common\models\base\Setting|string
     */
    public function getFavicon()
    {
        return $this->store->settings['website_favicon'] ?: $this->prefixStatic . '/img/favicon.ico';
    }

    /**
     * @return \common\models\base\Setting|string
     */
    public function getLogo()
    {
        return $this->store->settings['website_logo'] ?: $this->prefixStatic . '/img/logo.png';
    }

    public function getCss($name)
    {
        return $this->prefixStatic . '/css/' . $name;
    }

    public function getJs($name)
    {
        return $this->prefixStatic . '/js/' . $name;
    }

    public function getImage($name)
    {
        return $this->prefixStatic . '/img/' . $name;
    }

}
