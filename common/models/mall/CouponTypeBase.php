<?php

namespace common\models\mall;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%mall_coupon_type}}" to add your code.
 *
 * @property Coupon[] $coupons
 * @property Store $store
 */
class CouponTypeBase extends BaseModel
{
    const TYPE_PERCENT = 1;
    const TYPE_FIXED   = 2;
    const TYPE_GIFT_VOUCHER    = 9;

    public $startedTime;
    public $endedTime;

    public $users;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['startedTime', 'endedTime'], 'required', 'on' => 'backend-coupon-type-edit'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'backend-coupon-type-edit' => ['name', 'money', 'startedTime', 'endedTime', 'type'],
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
            'name' => Yii::t('app', 'Name'),
            'money' => Yii::t('app', 'Money'),
            'min_amount' => Yii::t('app', 'Min Amount'),
            'started_at' => Yii::t('app', 'Started At'),
            'startedTime' => Yii::t('app', 'Started At'),
            'ended_at' => Yii::t('app', 'Ended At'),
            'endedTime' => Yii::t('app', 'Ended At'),
            'sn' => Yii::t('app', 'Sn'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'users' => Yii::t('app', 'Users'),
        ];
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_PERCENT => Yii::t('cons', 'TYPE_PERCENT'),
            self::TYPE_FIXED => Yii::t('cons', 'TYPE_FIXED'),
        ];

        $all && $data += [
            self::TYPE_GIFT_VOUCHER => Yii::t('cons', 'TYPE_GIFT_VOUCHER'),
        ];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupons()
    {
        return $this->hasMany(Coupon::className(), ['coupon_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }

    public static function getMoneyLabel($model, $currency = '')
    {
        if ($model['type'] == self::TYPE_PERCENT) {
            return '-' . $model['money'] . '%';
        } else {
            return '-' . $currency . $model['money'];
        }
    }
}
