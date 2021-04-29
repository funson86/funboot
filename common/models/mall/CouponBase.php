<?php

namespace common\models\mall;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%mall_coupon}}" to add your code.
 *
 * @property User $user
 * @property CouponType $couponType
 * @property Store $store
 */
class CouponBase extends BaseModel
{
    const STATUS_USED = -2;

    public $startedTime;
    public $endedTime;

    public static function getStatusLabels($id = null, $all = false, $flip = false)
    {
        $data = parent::getStatusLabels(null, true);
        $data += [
            self::STATUS_USED => Yii::t('cons', 'STATUS_USED'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;

    }

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['startedTime', 'endedTime'], 'required', 'on' => 'backend-coupon-edit'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['coupon_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CouponType::className(), 'targetAttribute' => ['coupon_type_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'backend-coupon-edit' => ['name', 'money', 'startedTime', 'endedTime'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'coupon_type_id' => Yii::t('app', 'Coupon Type ID'),
            'name' => Yii::t('app', 'Name'),
            'money' => Yii::t('app', 'Money'),
            'min_amount' => Yii::t('app', 'Min Amount'),
            'started_at' => Yii::t('app', 'Started At'),
            'startedTime' => Yii::t('app', 'Started At'),
            'ended_at' => Yii::t('app', 'Ended At'),
            'endedTime' => Yii::t('app', 'Ended At'),
            'min_product_amount' => Yii::t('app', 'Min Product Amount'),
            'sn' => Yii::t('app', 'Sn'),
            'order_id' => Yii::t('app', 'Order ID'),
            'used_at' => Yii::t('app', 'Used At'),
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
    public function getCouponType()
    {
        return $this->hasOne(CouponType::className(), ['id' => 'coupon_type_id']);
    }
}
