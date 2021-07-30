<?php
namespace frontend\models\bbs;

use common\helpers\CommonHelper;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupEmailForm extends Model
{
    public $username;
    public $email;
    public $storeId;
    public $password;
    public $recommendedName;

    public function __construct($config = [])
    {
        !$this->storeId && $this->storeId = Yii::$app->storeSystem->getId();
    }

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
            ['email', 'checkExist'],
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

    public function checkExist($attribute, $params)
    {
        if (User::find()->where(['email' => $this->email, 'store_id' => ($this->storeId ?: Yii::$app->storeSystem->getId())])->one())
        {
            $this->addError($attribute, Yii::t('app', '{attribute} exist', ['attribute' => Yii::t('app', 'Email')]));
        }
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
            $user->username = str_replace('.', '_', str_replace('@', '_', $this->email));
            $user->email = $this->email;
            $user->store_id = $this->storeId ?: Yii::$app->storeSystem->getId();
            $user->setPassword($this->password);

            $store = Yii::$app->storeSystem->get();
            isset($store->settings['user_login_need_verify']) && $store->settings['user_login_need_verify'] > 0 && $user->status = User::STATUS_INACTIVE;

            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
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
    protected function sendEmail($user)
    {
        $content = CommonHelper::render(Yii::getAlias('@common/mail/bbs/emailVerify-html.php'), [
            'user' => $user,
        ], $this, Yii::getAlias('@common/mail/layouts/html.php'));

        $store = Yii::$app->storeSystem->get();
        Yii::$app->mailSystem->send($this->email, Yii::t('app', 'Account registration at ') . $store->host_name, $content);
    }
}
