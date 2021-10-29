<?php

namespace frontend\modules\mall\controllers;

use common\helpers\CommonHelper;
use common\models\User;
use Yii;

/**
 * Class BaseController
 * @package frontend\modules\mall\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends \frontend\controllers\BaseController
{
    public $pageSize = 24;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // 黑名单用户自动注销
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->status != User::STATUS_ACTIVE) {
            Yii::$app->user->logout();
        }

        // 设置当前货币
        if (!Yii::$app->session->get('currencyCurrent')) {
            Yii::$app->session->set('currencyCurrent', Yii::$app->settingSystem->getValue('mall_currency_default'));
        }

        return true;
    }
}
