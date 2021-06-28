<?php

namespace frontend\modules\bbs\controllers;

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
    // list page size
    protected $pageSize = 24;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // 黑名单用户自动注销
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->status != User::STATUS_ACTIVE) {
            Yii::$app->user->logout();
        }

        return true;
    }

    public function isManager()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        foreach (Yii::$app->user->identity->userRoles as $model) {
            if (in_array($model->role_id, Yii::$app->params['bbs']['managerRoleIds'] ?? [])) {
                return true;
            }
        }
        return false;
    }
}