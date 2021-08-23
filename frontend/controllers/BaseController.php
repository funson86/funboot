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

    // 模版类型 模板类型1，表示目录级别切换，模板类型为2，表示使用default模板，只是在颜色上微调
    public $themeType = 1;

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

        // 如果未设置(后台方式和前台方式都为指定)，前台强制为指定语言
        strlen($store->lang_frontend_default) > 0 && !Yii::$app->cacheSystem->getLanguage(Yii::$app->user->id ?? 0, Yii::$app->session->id) && !Yii::$app->request->get('lang') && Yii::$app->language = $store->lang_frontend_default;

        if (Yii::$app->defaultRoute != 'site') {
            $this->themeType == 1 && $this->theme = $store->settings[$store->route . '_theme'] ?? $store->settings['website_theme'] ?: 'default';
            $this->module->setViewPath('@webroot/resources/' . $store->route . '/' . $this->theme . '/views');
            $this->layout = 'main';
            $this->prefixStatic = Yii::getAlias('@web/resources/' . $store->route . '/' . $this->theme);
            $this->isMobile = CommonHelper::isMobile();
        } else {
            $routes = array_keys(Store::getRouteLabels());
            if (in_array($this->module->getUniqueId(), $routes)) {
                $this->module->setLayoutPath('@webroot/resources/' . $this->module->getUniqueId() . '/default/views/layouts');
                $this->module->setViewPath('@webroot/resources/' . $this->module->getUniqueId() . '/default/views');
                $this->layout = 'main';
                $this->prefixStatic = Yii::getAlias('@web/resources/' . $this->module->getUniqueId() . '/default');
            }
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

    public function getCss($name, $ext = null, $version = null)
    {
        !$ext && $ext = '.css';
        (strpos($name, '.') === false) && $name .= $ext;
        $version && $name .= $name . ('?v=' . $version);

        return $this->prefixStatic . '/css/' . $name;
    }

    public function getJs($name, $ext = null, $version = null)
    {
        !$ext && $ext = '.js';
        (strpos($name, '.') === false) && $name .= $ext;
        $version && $name .= '?v=' . $version;

        return $this->prefixStatic . '/js/' . $name;
    }

    public function getImage($name, $ext = null, $version = null)
    {
        !$ext && $ext = '.jpg';
        (strpos($name, '.') === false) && $name .= $ext;
        $version && $name .= '?v=' . $version;

        return $this->prefixStatic . '/images/' . $name;
    }

    public function getImageResponsive($name, $pc = null, $ext = null, $version = null)
    {
        !$ext && $ext = '.jpg';
        $name = CommonHelper::isMobile() ? $name : ($pc ?? str_replace('-h5', '', $name));
        (strpos($name, '.') === false) && $name .= $ext;
        $version && $name .= '?v=' . $version;

        return $this->prefixStatic . '/images/' . $name;
    }

    public function getImageResponsiveByLang($name, $langCode = null, $pc = null, $ext = null, $version = null)
    {
        !$ext && $ext = '.jpg';
        $name = CommonHelper::isMobile() ? $name : ($pc ?? str_replace('-h5', '', $name));
        if (strpos($name, '.') === false) {
            $langCode && $name .= '-' . $langCode;
            $name .= $ext;
        }

        if (file_exists(Yii::getAlias('@webroot' . $this->prefixStatic . '/images/' . $name))) {
            $version && $name .= '?v=' . $version;
            return $this->prefixStatic . '/images/' . $name;
        }

        $langCode && $name = str_replace('-' . $langCode, '', $name);
        $version && $name .= '?v=' . $version;
        return $this->prefixStatic . '/images/' . $name;
    }

}
