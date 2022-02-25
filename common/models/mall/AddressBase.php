<?php

namespace common\models\mall;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%mall_address}}" to add your code.
 *
 * @property User $user
 * @property Store $store
 */
class AddressBase extends BaseModel
{
    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['first_name', 'last_name', 'country', 'province', 'city', 'distinct', 'address', 'mobile'], 'required', 'on' => ['withoutRegion']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'withoutRegion' => ['first_name', 'last_name', 'country', 'province', 'city', 'distinct', 'address', 'mobile'],
        ]);
    }

    /** add function getXxxLabels here, detail in BaseModel **/

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
            'zipcode' => Yii::t('app', 'Zipcode'),
            'address2' => Yii::t('app', 'Address2'),
            'postcode' => Yii::t('app', 'Postcode'),
            'mobile' => Yii::t('app', 'Mobile'),
            'email' => Yii::t('app', 'Email'),
            'is_default' => Yii::t('app', 'Is Default'),
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
