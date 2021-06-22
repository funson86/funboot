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
    // 判断是否为手机版
    public $isMobile;

    //模板
    public $theme = 'default';

    // 资源文件前缀
    public $prefixStatic;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $store = $this->store;

        // 如果未设置，前台强制为指定语言
        strlen($store->lang_frontend_default) > 0 && !Yii::$app->cacheSystem->getLanguage(Yii::$app->user->id ?? 0, Yii::$app->session->id) && Yii::$app->language = $store->lang_frontend_default;

        if (Yii::$app->defaultRoute != 'site') {

            // 设置bbs登录地址
            Yii::$app->user->loginUrl = ['/' . $store->route. '/default/login'];

            $this->theme = $store->settings[$store->route . '_theme'] ?? $store->settings['website_theme'] ?: 'default';
            $this->module->setViewPath('@webroot/resources/' . $store->route . '/' . $this->theme . '/views');
            $this->layout = 'main';
            $this->prefixStatic = Yii::getAlias('@web/resources/' . $store->route . '/' . $this->theme);
            $this->isMobile = CommonHelper::isMobile();
        }

        return true;
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
