<?php

namespace frontend\controllers;

use common\helpers\CommonHelper;
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
            // 如果未设置，前台强制为指定语言
            strlen($this->store->lang_frontend_default) > 0 && !Yii::$app->cacheSystem->getLanguage(Yii::$app->user->id ?? 0, Yii::$app->session->id) && Yii::$app->language = $this->store->lang_frontend_default;
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
        return $this->store->settings['website_favicon'] ?: $this->prefixStatic . '/images/favicon.ico';
    }

    /**
     * @return \common\models\base\Setting|string
     */
    public function getLogo()
    {
        return $this->store->settings['website_logo'] ?: $this->prefixStatic . '/images/logo.png';
    }

    public function getCss($name, $ext = '.css')
    {
        if (strpos($name, '.') === false) {
            $name .= $ext;
        }

        return $this->prefixStatic . '/css/' . $name;
    }

    public function getJs($name, $ext = '.js')
    {
        if (strpos($name, '.') === false) {
            $name .= $ext;
        }

        return $this->prefixStatic . '/js/' . $name;
    }

    public function getImage($name, $ext = '.jpg')
    {
        if (strpos($name, '.') === false) {
            $name .= $ext;
        }

        return $this->prefixStatic . '/images/' . $name;
    }

    public function getImageResponsive($name, $pc = null, $ext = '.jpg')
    {
        $name = CommonHelper::isMobile() ? $name : ($pc ?? str_replace('-h5', '', $name));
        if (strpos($name, '.') === false) {
            $name .= $ext;
        }

        return $this->prefixStatic . '/images/' . $name;
    }

    public function getImageResponsiveByLang($name, $langCode = null, $pc = null, $ext = '.jpg')
    {
        $name = CommonHelper::isMobile() ? $name : ($pc ?? str_replace('-h5', '', $name));
        if (strpos($name, '.') === false) {
            $langCode && $name .= '-' . $langCode;
            $name .= $ext;
        }

        if (file_exists(Yii::getAlias('@webroot' . $this->prefixStatic . '/images/' . $name))) {
            return $this->prefixStatic . '/images/' . $name;
        }

        $langCode && $name = str_replace('-' . $langCode, '', $name);
        return $this->prefixStatic . '/images/' . $name;
    }

}
