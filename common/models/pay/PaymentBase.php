<?php

namespace common\models\pay;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%pay_payment}}" to add your code.
 *
 * @property Store $store
 */
class PaymentBase extends BaseModel
{
    public $kind = 10;
    public $verifyCode;

    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;
    const STATUS_PAID_WITHOUT_LIST = 2;

    const KIND_A = 10;
    const KIND_B = 1000;
    const KIND_C = 19900;
    const KIND_D = 0;


    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['email'], 'required'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
            ['verifyCode', 'captcha', 'on' => 'captchaRequired'],
        ];
    }

    public static function getStatusLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::STATUS_PAID => Yii::t('cons', 'STATUS_PAID'),
            self::STATUS_UNPAID => Yii::t('cons', 'STATUS_UNPAID'),
            self::STATUS_EXPIRED => Yii::t('cons', 'STATUS_EXPIRED'),
            self::STATUS_DELETED => Yii::t('cons', 'STATUS_DELETED'),
            self::STATUS_PAID_WITHOUT_LIST => Yii::t('cons', 'STATUS_PAID_WITHOUT_LIST'),
        ];

        $all && $data += [
        ];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getKindLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::KIND_A => Yii::t('cons', '￥0.10 测试'),
            self::KIND_B => Yii::t('cons', '￥10.00 FunPay最新版本和文档'),
            self::KIND_D => Yii::t('cons', '自定义金额'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'bank_code' => Yii::t('app', 'Bank Code'),
            'money' => Yii::t('app', 'Money'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'email_exp' => Yii::t('app', 'Email Exp'),
            'remark' => Yii::t('app', 'Remark'),
            'kind' => Yii::t('app', 'Kind'),
            'sn' => Yii::t('app', 'Sn'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }

    /**
     * 验证码显示判断
     */
    public function captchaRequired()
    {
        if (Yii::$app->session->get('paymentSubmit') >= $this->getAttempts()) {
            $this->setScenario("captchaRequired");
        }
    }

    protected function getAttempts()
    {
        return Yii::$app->params['paymentSubmitAttempts'] ?? 3;
    }
}
