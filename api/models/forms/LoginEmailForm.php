<?php
namespace api\models\forms;

use api\models\User;
use yii\base\Model;
use Yii;

/**
 * Class LoginEmailForm
 * @author funson86 <funson86@gmail.com>
 */
class LoginEmailForm extends Model
{
    public $storeId;
    public $email;
    public $password;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['email', 'validateStatus'],
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

    public function getUser()
    {
        !$this->storeId && $this->storeId = Yii::$app->storeSystem->getId();
        if ($this->_user === null) {
            $this->_user = User::findByEmailAndStoreId($this->email, $this->storeId);
        }

        return $this->_user;
    }
}