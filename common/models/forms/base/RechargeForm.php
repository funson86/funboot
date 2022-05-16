<?php

namespace common\models\forms\base;

use common\helpers\IdHelper;
use common\models\base\Recharge;
use Yii;

/**
 * Class RechargeForm
 * @package common\models\forms\base
 * @author funson86 <funson86@gmail.com>
 */
class RechargeForm extends \yii\base\Model
{
    public $amount = 50;
    public $message;
    public $verifyCode;

    const KEY_FAILED = 'rechargeFailed';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'required'],
            [['amount'], 'number'],
            [['message'], 'safe'],
            ['verifyCode', 'captcha', 'captchaAction' => 'site/captcha', 'on' => 'captchaRequired'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'amount' => Yii::t('app', 'Amount'),
            'message' => Yii::t('app', 'Message'),
            'verifyCode' => Yii::t('app', 'Verify Code'),
        ];
    }

    /**
     * 显示判断
     */
    public function checkCaptchaRequired()
    {
        if (Yii::$app->session->get(self::KEY_FAILED) >= $this->getAttempts()) {
            $this->setScenario(self::KEY_FAILED);
        }
    }

    public function build()
    {
        $store = Yii::$app->storeSystem->get();
        $model = new Recharge();
        $model->id = IdHelper::snowFlakeId();
        $model->sn = IdHelper::snowFlakeId();
        $model->amount = $this->amount;
        $model->email = Yii::$app->user->isGuest ? '' : (Yii::$app->user->identity->email ?: '');
        $model->name = 'Recharge of ' . $model->amount;
        $model->remark = $this->message;
        $model->mobile = Yii::$app->user->identity->mobile;
        $model->user_id = Yii::$app->user->isGuest ? $store->user_id :Yii::$app->user->id;
        $model->payment_status = Recharge::PAYMENT_STATUS_UNPAID;
        $this->beforeSave($model);
        if (!$model->save()) {
            Yii::$app->session->set(self::KEY_FAILED, Yii::$app->session->get(self::KEY_FAILED, 0) + 1);
            Yii::$app->logSystem->db($model->errors);
            return false;
        }

        $this->afterSave($model);

        return $model;
    }

    protected function beforeSave($model)
    {
        return true;
    }

    protected function afterSave($model)
    {
        return true;
    }

    protected function getAttempts()
    {
        return Yii::$app->params[self::KEY_FAILED] ?? 3;
    }
}
