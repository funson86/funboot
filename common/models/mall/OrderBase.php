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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'sn' => Yii::t('app', 'Sn'),
            'consignee' => Yii::t('app', 'Consignee'),
            'country_id' => Yii::t('app', 'Country ID'),
            'province_id' => Yii::t('app', 'Province ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'district_id' => Yii::t('app', 'District ID'),
            'state' => Yii::t('app', 'State'),
            'address' => Yii::t('app', 'Address'),
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'zipcode' => Yii::t('app', 'Zipcode'),
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }

}
