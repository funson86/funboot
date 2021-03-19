<?php

namespace common\components\wechat;

/**
 * Class WechatUser
 * @package common\components\wechat
 * @author funson86 <funson86@gmail.com>
 */
class WechatUser extends \yii\base\Component
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $nickname;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $avatar;
    /**
     * @var array
     */
    public $original;
    /**
     * @var \Overtrue\Socialite\AccessToken
     */
    public $token;
    /**
     * @var string
     */
    public $provider;

    /**
     * @return string
     */
    public function getOpenId()
    {
        return isset($this->original['openid']) ? $this->original['openid'] : '';
    }
}
