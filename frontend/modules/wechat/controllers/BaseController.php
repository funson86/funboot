<?php

namespace frontend\modules\wechat\controllers;

use common\models\User;
use common\traits\WechatLogin;
use Yii;

/**
 * Default controller for the `wechat` module
 */
class BaseController extends \frontend\controllers\BaseController
{
    use WechatLogin;

    /**
     * 要鉴权中不需要鉴权的action id
     * @var string[]
     */
    public $optionalAuth = [];

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!in_array($this->action->id, $this->optionalAuth)) {
            return $this->login();
        }

        return true;
    }

    public function afterLogin()
    {
        // 将Yii::$app->params['wechat']['userInfo']数据插入user表中
        $user = Yii::$app->params['wechat']['userInfo'];
        if (!is_array($user)) {
            return false;
        }

        $model = User::findByOpenid($user['id']);
        if (!$model) {
            $original = Yii::$app->params['wechat']['userInfo']['original'];
            $model = new User();
            $model->openid = $model->username = $model['id'];
            $model->name = $user['nickname'];
            $model->sex = $user['sex'];
            $model->avatar = $user['avatar'];
            if (!$model->save()) {
                Yii::$app->logSystem->db($model->errors);
                return false;
            }

            // 登录
            Yii::$app->user->login($model);
        }

        return true;
    }
}
