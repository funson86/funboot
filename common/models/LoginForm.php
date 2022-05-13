<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\captcha\Captcha;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $rememberMe = true;

    const KEY_FAILED = 'loginFailed';

    protected $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha', 'captchaAction' => 'site/captcha', 'on' => 'captchaRequired'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'rememberMe' => Yii::t('app', 'Remember Me'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'verifyCode' => Yii::t('app', 'Verify Code'),
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        // 记录失败次数
        Yii::$app->session->set(self::KEY_FAILED, Yii::$app->session->get(self::KEY_FAILED, 0) + 1);
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * 验证码显示判断
     */
    public function checkCaptchaRequired()
    {
        if (Yii::$app->session->get(self::KEY_FAILED) >= $this->getAttempts()) {
            $this->setScenario("captchaRequired");
        }
    }

    protected function getAttempts()
    {
        return Yii::$app->params['loginAttempts'] ?? 3;
    }
}
