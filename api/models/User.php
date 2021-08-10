<?php

namespace api\models;

use yii\filters\RateLimitInterface;
use Yii;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/**
 * Class User
 * @package api\models
 * @author funson86 <funson86@gmail.com>
 */
class User extends \common\models\User implements RateLimitInterface
{
    //速率限制，如 100s 内 20 次，可以在param.php中设置频率
    public $rateLimit = 20;
    public $timeLimit = 100;

    public function init()
    {
        parent::init();
        isset(Yii::$app->params['rateLimit']) && ($this->rateLimit = Yii::$app->params['rateLimit']);
        isset(Yii::$app->params['timeLimit']) && $this->timeLimit = Yii::$app->params['timeLimit'];
    }

    public function fields()
    {
        return ['id', 'access_token', 'username', 'email', 'store'];
    }

    public function extraFields()
    {
        return ['store'];
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return User|mixed|void|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if (Yii::$app->params['user']['accessTokenValid']) {
            $time = intval(substr($token, strrpos($token, '_') + 1));
            $expire = intval(Yii::$app->params['user']['accessTokenExpired']);
            if (($time + $expire) < time()) {
                throw new UnauthorizedHttpException(Yii::t('app', 'Token Expired'));
            }
        }
        return Yii::$app->accessTokenSystem->getFromCache($token, $type);
    }

    /**
     * 返回允许请求的最大次数和时间周期
     */
    public function getRateLimit($request, $action)
    {
        return [$this->rateLimit, $this->timeLimit];
    }

    /**
     * 返回限制频率最后一次检测时剩余的请求次数和相应的UNIX时间戳
     */
    public function loadAllowance($request, $action)
    {
        $data = Yii::$app->cache->get($this->generateKeyIdentity($this->id, Yii::$app->requestedRoute));
        return empty($data) ? [$this->rateLimit, time()] : json_decode($data);
    }

    /**
     * 保存剩余的请求次数和当前的UNIX时间戳
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        Yii::$app->cache->set($this->generateKeyIdentity($this->id, Yii::$app->requestedRoute), json_encode([$allowance, $timestamp]));
    }

    /**
     * 生成速率限制，唯一标识 key
     * @param string $id 用户唯一标识
     * @param string $actionId 校验方法
     * @return string
     */
    public function generateKeyIdentity($id, $actionId){
        return 'apiRate:' . md5($id . '_' . $actionId);
    }

    public function getStore()
    {
        return parent::getStore() ? parent::getStore()->select(['name']) : null;
    }
}
