<?php
namespace common\models\forms\base;

use common\helpers\IdHelper;
use common\models\base\Message;
use Yii;
use yii\base\Model;

/**
 * FeedbackForm form
 */
class FeedbackForm extends Model
{
    public $name;
    public $mobile;
    public $email;
    public $content;
    public $verifyCode;

    const KEY_FAILED = 'feedbackFailed';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mobile', 'content'], 'required'],
            [['email'], 'safe'],
            ['verifyCode', 'captcha', 'on' => 'captchaRequired'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'mobile' => Yii::t('app', 'Mobile'),
            'email' => Yii::t('app', 'Email'),
            'content' => Yii::t('app', 'Content'),
            'verifyCode' => Yii::t('app', 'Verify Code'),
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function create()
    {
        if ($this->validate()) {
            $content = [
                'name' => $this->name,
                'mobile' => $this->mobile,
                'email' => $this->email,
                'content' => $this->content,
            ];
            if (Message::create(Yii::t('app', "Feedback Form {$this->name} of {$content['datetime']}"), $content)) {
                return true;
            } else {
                Yii::$app->logSystem->db($content);
            }
        }

        // 记录失败次数
        Yii::$app->session->set(self::KEY_FAILED, Yii::$app->session->get(self::KEY_FAILED, 0) + 1);
        return false;
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
        return Yii::$app->params['feedbackAttempts'] ?? 3;
    }
}
