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
            [['mobile'], 'number'],
            [['content'], 'checkSpam'],
            ['verifyCode', 'captcha', 'captchaAction' => 'site/captcha', 'on' => 'captchaRequired'],
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
            if (Message::create(Yii::t('app', "Feedback from {$this->name}"), $content)) {
                return true;
            } else {
                Yii::$app->logSystem->db($content);
            }
        }

        // 记录失败次数
        Yii::$app->session->set(self::KEY_FAILED, Yii::$app->session->get(self::KEY_FAILED, 0) + 1);
        return false;
    }

    public function checkSpam($attribute, $params)
    {
        $keywords = Yii::$app->params['spamKeywords'] ?? [];
        $str = strtolower($this->content);
        foreach ($keywords as $keyword) {
            if (strpos($str, $keyword) !== false) {
                $this->addError($attribute, Yii::t('app', '{attribute} contains spam keyword', ['attribute' => Yii::t('app', 'Content')]));
            }
        }
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
