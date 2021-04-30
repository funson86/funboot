<?php

namespace common\models\mall;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%mall_address}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $user_id 用户
 * @property string $name 名称
 * @property string $consignee 联系人
 * @property int $country_id 国家
 * @property int $province_id 省
 * @property int $city_id 市
 * @property int $district_id 区
 * @property string $address 地址
 * @property string $zipcode 邮编
 * @property string $mobile 手机
 * @property string $email 邮箱
 * @property int $is_default 默认地址
 * @property int $type 排序
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Address extends AddressBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mall_address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'user_id', 'country_id', 'province_id', 'city_id', 'district_id', 'is_default', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['name', 'consignee', 'address', 'zipcode', 'mobile', 'email'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        if (Yii::$app->language == Yii::$app->params['sqlCommentLanguage']) {
            return array_merge(parent::attributeLabels(), [
                'id' => Yii::t('app', 'ID'),
                'store_id' => '商家',
                'user_id' => '用户',
                'name' => '名称',
                'consignee' => '联系人',
                'country_id' => '国家',
                'province_id' => '省',
                'city_id' => '市',
                'district_id' => '区',
                'address' => '地址',
                'zipcode' => '邮编',
                'mobile' => '手机',
                'email' => '邮箱',
                'is_default' => '默认地址',
                'type' => '排序',
                'sort' => '排序',
                'status' => '状态',
                'created_at' => '创建时间',
                'updated_at' => '更新时间',
                'created_by' => '创建用户',
                'updated_by' => '更新用户',
            ]);
        } else {
            return array_merge(parent::attributeLabels(), [
                'id' => Yii::t('app', 'ID'),
                'store_id' => Yii::t('app', 'Store ID'),
                'user_id' => Yii::t('app', 'User ID'),
                'name' => Yii::t('app', 'Name'),
                'consignee' => Yii::t('app', 'Consignee'),
                'country_id' => Yii::t('app', 'Country ID'),
                'province_id' => Yii::t('app', 'Province ID'),
                'city_id' => Yii::t('app', 'City ID'),
                'district_id' => Yii::t('app', 'District ID'),
                'address' => Yii::t('app', 'Address'),
                'zipcode' => Yii::t('app', 'Zipcode'),
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
}
