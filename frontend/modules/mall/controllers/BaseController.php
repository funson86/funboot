<?php

namespace frontend\modules\mall\controllers;

use common\helpers\CommonHelper;
use Yii;

/**
 * Class BaseController
 * @package frontend\modules\mall\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends \frontend\controllers\BaseController
{
    // 判断是否为手机版
    public $isMobile;

    //模板
    public $theme;

    // 资源文件前缀
    public $prefixStatic;

    public function beforeAction($action)
    {
        // 设置mall登录地址
        Yii::$app->user->loginUrl = ['/mall/default/login'];

        if (!parent::beforeAction($action)) {
            return false;
        }

        $store = $this->getStore();
        if (!$store) {
            return false;
        }

        $this->theme = $store->settings['cms_theme'] ?? 'default';
        $this->module->setViewPath('@webroot/resources/mall/' . $this->theme . '/views');
        $this->layout = 'main';
        $this->prefixStatic = '/resources/mall/' . $this->theme;
        $this->isMobile = CommonHelper::isMobile();

        return true;
    }
}