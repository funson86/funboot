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
    // list page size
    protected $pageSize = 24;

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