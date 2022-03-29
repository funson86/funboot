<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%base_recharge}}" to add your code.
 *
 * @property User $user
 * @property Store $store
 */
class RechargeBase extends BaseModel
{
    const PAYMENT_STATUS_UNPAID = 20;
    const PAYMENT_STATUS_REFUND = 21;
    const PAYMENT_STATUS_PAYING = 30;
    const PAYMENT_STATUS_PAID = 40;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /** add function getXxxLabels here, detail in BaseModel **/
    public static function getPaymentStatusLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::PAYMENT_STATUS_UNPAID => Yii::t('cons', 'PAYMENT_STATUS_UNPAID'),
            self::PAYMENT_STATUS_REFUND => Yii::t('cons', 'PAYMENT_STATUS_REFUND'),
            self::PAYMENT_STATUS_PAYING => Yii::t('cons', 'PAYMENT_STATUS_PAYING'),
            self::PAYMENT_STATUS_PAID => Yii::t('cons', 'PAYMENT_STATUS_PAID'),
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
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'sn' => Yii::t('app', 'Sn'),
            'mobile' => Yii::t('app', 'Mobile'),
            'email' => Yii::t('app', 'Email'),
            'remark' => Yii::t('app', 'Remark'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'paid_at' => Yii::t('app', 'Paid At'),
            'amount' => Yii::t('app', 'Amount'),
            'tax' => Yii::t('app', 'Tax'),
            'invoice' => Yii::t('app', 'Invoice'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ]);
    }

}
