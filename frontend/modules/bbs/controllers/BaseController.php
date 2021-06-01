<?php

namespace frontend\modules\bbs\controllers;

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

    protected $pageSize = 24;

    //模板
    public $theme = 'default';

    // 资源文件前缀
    public $prefixStatic;

    public function beforeAction($action)
    {
        // 设置bbs登录地址
        Yii::$app->user->loginUrl = ['/bbs/default/login'];

        if (!parent::beforeAction($action)) {
            return false;
        }

        $store = $this->getStore();
        if (!$store) {
            return false;
        }

        $this->theme = $store->settings['bbs_theme'] ?? 'default';
        $this->module->setViewPath('@webroot/resources/bbs/' . $this->theme . '/views');
        $this->layout = 'main';
        $this->prefixStatic = Yii::getAlias('@web/resources/' . $store->route . '/' . $this->theme);
        $this->isMobile = CommonHelper::isMobile();

        return true;
    }

    public function isAdmin()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        foreach (Yii::$app->user->identity->userRoles as $model) {
            if (in_array($model->role_id, Yii::$app->params['bbs']['adminRoleIds'])) {
                return true;
            }
        }
        return false;
    }
}