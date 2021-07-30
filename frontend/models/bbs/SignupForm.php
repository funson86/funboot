<?php
namespace frontend\models\bbs;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $storeId;
    public $password;
    public $recommendedName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            ['username', 'trim'],
//            ['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
//            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'repassword' => Yii::t('app', 'Repassword'),
            'email' => Yii::t('app', 'Email'),
            'balance' => Yii::t('app', 'Balance'),
            'point' => Yii::t('app', 'Point'),
            'recommended_by' => Yii::t('app', 'Recommended By'),
            'recommended_name' => Yii::t('app', 'Recommended Name'),
            'supported_by' => Yii::t('app', 'Supported By'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'recommendedName' => Yii::t('app', 'Recommended Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = str_replace('.', '', str_replace('@', '', $this->username));
            $user->email = $this->email;
            $user->store_id = $this->storeId;
            $user->setPassword($this->password);

            $user->generateAuthKey();
            if ($user->save()) {
                $this->sendEmail($user);
                return $user;
            } else {
                Yii::error($user->errors);
            }
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($model)
    {
        $subject = 'Account registration at' . Yii::$app->storeSystem->get()->host_name . ', Thank you';
        $verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/bbs/default/verify-email', 'token' => $model->verification_token]);
        $content = 'Follow the link below to verify your email: ' . $verifyLink;
        Yii::$app->mailSystem->send($model->email, $subject, $content);
    }
}
