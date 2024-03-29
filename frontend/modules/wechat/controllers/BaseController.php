<?php

namespace frontend\modules\wechat\controllers;

use common\helpers\IdHelper;
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

        // 必须鉴权且为游客
        if (!in_array($this->action->id, $this->optionalAuth) && Yii::$app->user->isGuest) {
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
            $model->openid = $model->username = $user['id'];
            $model->name = $user['nickname'];
            $model->sex = $original['sex'];
            $model->avatar = $user['avatar'];
            $model->access_token = $user['access_token'];
            $model->refresh_token = $user['refresh_token'];
            $model->setPassword(IdHelper::snowFlakeId());
            $model->generateAuthKey();
            if (!$model->save()) {
                Yii::$app->logSystem->db($model->errors);
                return false;
            }

        }

        // 登录
        Yii::$app->user->login($model);

        return true;
    }
}
