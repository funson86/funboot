<?php
namespace common\models\forms\mall;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\captcha\Captcha;

/**
 * Login form
 */
class LoginEmailForm extends \common\models\forms\LoginEmailForm
{
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
            ['verifyCode', 'captcha', 'captchaAction' => '/mall/default/captcha', 'on' => 'captchaRequired'],
        ];
    }
}
