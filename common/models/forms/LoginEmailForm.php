<?php
namespace common\models\forms;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\captcha\Captcha;

/**
 * Login form
 */
class LoginEmailForm extends Model
{
    public $storeId;
    public $email;
    public $password;
    public $verifyCode;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['email', 'validateStatus'],
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
                $this->addError($attribute, Yii::t('app', 'Incorrect email or password.'));
            }
        }
    }

    /**
     * Check status.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateStatus($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user->status != User::STATUS_ACTIVE) {
                $this->addError($attribute, Yii::t('app', 'Please check your inbox for verification email to enable account.'));
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
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'verifyCode' => Yii::t('app', 'Verify Code'),
        ];
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        // 记录失败次数
        Yii::$app->session->set('loginFailed', Yii::$app->session->get('loginFailed', 0) + 1);
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        !$this->storeId && $this->storeId = Yii::$app->storeSystem->getId();
        if ($this->_user === null) {
            $this->_user = User::findByEmailAndStoreId($this->email, $this->storeId);
        }

        return $this->_user;
    }

    /**
     * 验证码显示判断
     */
    public function checkCaptchaRequired()
    {
        if (Yii::$app->session->get('loginFailed') >= $this->getAttempts()) {
            $this->setScenario("captchaRequired");
        }
    }

    protected function getAttempts()
    {
        return Yii::$app->params['loginAttempts'] ?? 3;
    }
}
