<?php

namespace api\models\forms;

use api\models\User;
use yii\base\Model;
use Yii;
use yii\web\UnauthorizedHttpException;

/**
 * Class RefreshForm
 * @package api\models\forms
 * @author funson86 <funson86@gmail.com>
 */
class RefreshForm extends Model
{
    public $refresh_token;
    public $verifyCode;
    public $rememberMe = true;

    protected $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['refresh_token'], 'required'],
            // password is validated by validatePassword()
            ['refresh_token', 'validateToken'],
            ['verifyCode', 'captcha', 'on' => 'captchaRequired'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateToken($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (Yii::$app->params['user']['refreshTokenValid']) {
                $token = $this->refresh_token;
                $time = intval(substr($token, strrpos($token, '_') + 1));
                $expire = intval(Yii::$app->params['user']['refreshTokenExpired']);
                if (($time + $expire) < time()) {
                    throw new UnauthorizedHttpException(Yii::t('app', 'Refresh Token Expired'));
                }
            }
        }

        if (!$this->getUser()) {
            throw new UnauthorizedHttpException(Yii::t('app', 'Invalid Token'));
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'refresh_token' => Yii::t('app', 'Refresh Token'),
            'verifyCode' => Yii::t('app', 'Verify Code'),
        ];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findIdentityByRefreshToken($this->refresh_token);
        }

        return $this->_user;
    }

    /**
     * 验证码显示判断
     */
    public function loginCaptchaRequired()
    {
        if (Yii::$app->session->get('refreshTokenFailed') >= $this->getAttempts()) {
            $this->setScenario("captchaRequired");
        }
    }

    protected function getAttempts()
    {
        return Yii::$app->params['refreshTokenAttempts'] ?? 3;
    }
}