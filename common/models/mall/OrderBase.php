<?php

namespace common\models\mall;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%mall_order}}" to add your code.
 *
 * @property User $user
 * @property Store $store
 */
class OrderBase extends BaseModel
{
    const PAYMENT_METHOD_PAY = 1;
    const PAYMENT_METHOD_COD = 2;

    const PAYMENT_STATUS_COD = 10;
    const PAYMENT_STATUS_UNPAID = 20;
    const PAYMENT_STATUS_REFUND = 21;
    const PAYMENT_STATUS_PAYING = 30;
    const PAYMENT_STATUS_PAID = 40;

    const SHIPMENT_STATUS_UNSHIPPED = 60;
    const SHIPMENT_STATUS_PREPARING = 70;
    const SHIPMENT_STATUS_SHIPPING = 80;
    const SHIPMENT_STATUS_RECEIVED = 90;

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
            self::PAYMENT_STATUS_COD => Yii::t('cons', 'PAYMENT_STATUS_COD'),
            self::PAYMENT_STATUS_UNPAID => Yii::t('cons', 'PAYMENT_STATUS_UNPAID'),
            self::PAYMENT_STATUS_REFUND => Yii::t('cons', 'PAYMENT_STATUS_REFUND'),
            self::PAYMENT_STATUS_PAYING => Yii::t('cons', 'PAYMENT_STATUS_PAYING'),
            self::PAYMENT_STATUS_PAID => Yii::t('cons', 'PAYMENT_STATUS_PAID'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    public static function getShipmentStatusLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::SHIPMENT_STATUS_UNSHIPPED => Yii::t('cons', 'SHIPMENT_STATUS_UNSHIPPED'),
            self::SHIPMENT_STATUS_PREPARING => Yii::t('cons', 'SHIPMENT_STATUS_PREPARING'),
            self::SHIPMENT_STATUS_SHIPPING => Yii::t('cons', 'SHIPMENT_STATUS_SHIPPING'),
            self::SHIPMENT_STATUS_RECEIVED => Yii::t('cons', 'SHIPMENT_STATUS_RECEIVED'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    public static function getStatusLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::STATUS_ACTIVE => Yii::t('cons', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('cons', 'STATUS_INACTIVE'),
            self::STATUS_EXPIRED => Yii::t('cons', 'STATUS_EXPIRED'),
            self::STATUS_DELETED => Yii::t('cons', 'STATUS_DELETED'),
        ] + self::getPaymentStatusLabels() + self::getShipmentStatusLabels();

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
            'address_id' => Yii::t('app', 'Address ID'),
            'name' => Yii::t('app', 'Name'),
            'sn' => Yii::t('app', 'Sn'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'country_id' => Yii::t('app', 'Country ID'),
            'country' => Yii::t('app', 'Country'),
            'province_id' => Yii::t('app', 'Province ID'),
            'province' => Yii::t('app', 'Province'),
            'city_id' => Yii::t('app', 'City ID'),
            'city' => Yii::t('app', 'City'),
            'district_id' => Yii::t('app', 'District ID'),
            'district' => Yii::t('app', 'District'),
            'address' => Yii::t('app', 'Address'),
            'address2' => Yii::t('app', 'Address2'),
            'postcode' => Yii::t('app', 'Postcode'),
            'mobile' => Yii::t('app', 'Mobile'),
            'email' => Yii::t('app', 'Email'),
            'distance' => Yii::t('app', 'Distance'),
            'remark' => Yii::t('app', 'Remark'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'payment_fee' => Yii::t('app', 'Payment Fee'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'paid_at' => Yii::t('app', 'Paid At'),
            'shipment_id' => Yii::t('app', 'Shipment ID'),
            'shipment_name' => Yii::t('app', 'Shipment Name'),
            'shipment_fee' => Yii::t('app', 'Shipment Fee'),
            'shipment_status' => Yii::t('app', 'Shipment Status'),
            'shipped_at' => Yii::t('app', 'Shipped At'),
            'product_amount' => Yii::t('app', 'Product Amount'),
            'amount' => Yii::t('app', 'Amount'),
            'number' => Yii::t('app', 'Number'),
            'extra_fee' => Yii::t('app', 'Extra Fee'),
            'discount' => Yii::t('app', 'Discount'),
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


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }

}
