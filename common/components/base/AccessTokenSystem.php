<?php

namespace common\components\base;

use common\helpers\ArrayHelper;
use api\models\User;
use Yii;

/**
 * Class AccessTokenSystem
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class AccessTokenSystem extends \yii\base\Component
{
    /**
     * 过期时间
     * @var int
     */
    public $timeout = 360;

    /** 刷新token
     * @param User $model
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function getAccessToken(User $model)
    {
        !empty($model->access_token) && Yii::$app->cache->delete($this->getCacheKey($model->access_token));
        $model->access_token = Yii::$app->security->generateRandomString() . '_' . time();
        $model->refresh_token = Yii::$app->security->generateRandomString() . '_' . time();
        if (!$model->save(false)) {
            Yii::$app->logSystem->db($model->errors);
        }

        Yii::$app->user->login($model);
        $this->saveToCache($this->getCacheKey($model->access_token), $model);
        return $model;
    }

    public function disableAccessToken($accessToken)
    {
        Yii::$app->cache->delete($this->getCacheKey($accessToken));
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            $model = User::findUserByAccessToken($accessToken);
            $model->access_token = '';
            if (!$model->save(false)) {
                Yii::$app->logSystem->db($model->errors);
                return false;
            }
            return Yii::$app->user->logout();
        }

        return false;
    }

    public function getCacheKey($accessToken)
    {
        return 'apiAt:' . $accessToken;
    }

    public function saveToCache($token, $model, $time = null)
    {
        !$time && $time = Yii::$app->params['user']['accessTokenExpired'] ?? $this->timeout;
        Yii::$app->cache->set($token, $model, $time);
    }

    public function getFromCache($token, $type = null)
    {
        return Yii::$app->cache->get($this->getCacheKey($token)) ?? User::findUserByAccessToken($token, $type);
    }
}
