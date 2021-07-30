<?php


namespace frontend\models\bbs;

use common\helpers\CommonHelper;
use Yii;
use common\models\User;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
    public $email;

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => Yii::t('app', 'There is no user with this email address.')
            ],
        ];
    }

    /**
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $user = User::findOne([
            'store_id' => Yii::$app->storeSystem->getId(),
            'email' => $this->email,
            'status' => User::STATUS_INACTIVE
        ]);

        if ($user === null) {
            return false;
        }

        $content = CommonHelper::render(Yii::getAlias('@common/mail/bbs/emailVerify-html.php'), [
            'user' => $user,
        ], $this, Yii::getAlias('@common/mail/layouts/html.php'));

        Yii::$app->mailSystem->send($this->email, Yii::t('app', 'Resend verification email'), $content);
        return true;
    }
}
