<?php

namespace common\traits;

use Yii;
use yii\helpers\Json;

/**
 * Trait WechatLogin
 * @package common\traits
 * @author funson86 <funson86@gmail.com>
 */
trait WechatLogin
{
    public function login()
    {
        /** 检测到微信进入自动获取用户信息 **/
        if (Yii::$app->wechat->isWechat && !Yii::$app->wechat->isAuthorized()) {
            return Yii::$app->wechat->authorizeRequired()->send();
        }

        Yii::$app->params['wechat']['userInfo'] = Json::decode(Yii::$app->wechat->getUserBySession());

        // 静默登录则不写入数据库
        if (in_array('snsapi_base', (Yii::$app->params['wechat']['wechatConfig']['oauth']['scopes'] ?? []))) {
            return true;
        }

        // 由使用该trait的类覆盖
        return $this->afterLogin();
    }


    /**
     * 由使用该trait的类覆盖
     * @return bool
     */
    public function afterLogin()
    {
        return true;
    }
}
