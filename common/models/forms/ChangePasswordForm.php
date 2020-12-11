<?php

namespace common\models\forms;

use yii\base\Model;
use Yii;
use common\models\User;

/**
 * Class ChangePasswordForm
 * @package common\models\forms
 * @author funson86 <funson86@gmail.com>
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $repassword;
    public $oldpassword;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute' => 'password'],
            ['oldpassword', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'oldpassword' => Yii::t('app', 'Old Password'),
            'password' => Yii::t('app', 'New Password'),
            'repassword' => Yii::t('app', 'Repassword'),
        ];
    }
    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function changePassword()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save();
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
            if (!$user || !$user->validatePassword($this->oldpassword)) {
                $this->addError($attribute, Yii::t('app', 'Incorrect old password.'));
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(Yii::$app->user->identity->id);
        }

        return $this->_user;
    }
}
