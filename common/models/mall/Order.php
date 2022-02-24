<?php

namespace common\models\mall;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%mall_order}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $user_id 用户
 * @property int $address_id 地址ID
 * @property string $name 名称
 * @property string $sn 编号
 * @property string $first_name 名字
 * @property string $last_name 姓氏
 * @property int $country_id 国家
 * @property string $country 国家
 * @property int $province_id 省
 * @property string $province 省
 * @property int $city_id 市
 * @property string $city 市
 * @property int $district_id 区
 * @property string $district 区
 * @property string $address 地址
 * @property string $address2 地址2
 * @property string $postcode 邮编
 * @property string $mobile 手机
 * @property string $email 邮箱
 * @property float $distance 距离
 * @property string $remark 备注
 * @property int $payment_method 支付方式
 * @property float $payment_fee 支付手续费
 * @property int $payment_status 支付状态
 * @property int $paid_at 支付时间
 * @property int $shipment_id 配送公司
 * @property string $shipment_name 配送名称
 * @property float $shipment_fee 配送费
 * @property int $shipment_status 配送状态
 * @property int $shipped_at 配送时间
 * @property float $product_amount 商品总价
 * @property float $amount 支付金额
 * @property int $number 数量
 * @property float $extra_fee 额外费用
 * @property float $discount 优惠金额
 * @property float $tax 税费
 * @property string $invoice 发票
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Order extends OrderBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mall_order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'user_id', 'address_id', 'country_id', 'province_id', 'city_id', 'district_id', 'payment_method', 'payment_status', 'paid_at', 'shipment_id', 'shipment_status', 'shipped_at', 'number', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_id', 'sn'], 'required'],
            [['distance', 'payment_fee', 'shipment_fee', 'product_amount', 'amount', 'extra_fee', 'discount', 'tax'], 'number'],
            [['name', 'sn', 'first_name', 'last_name', 'country', 'province', 'city', 'district', 'address', 'address2', 'postcode', 'mobile', 'email', 'remark', 'shipment_name', 'invoice'], 'string', 'max' => 255],
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
                'address_id' => '地址ID',
                'name' => '名称',
                'sn' => '编号',
                'first_name' => '名字',
                'last_name' => '姓氏',
                'country_id' => '国家',
                'country' => '国家',
                'province_id' => '省',
                'province' => '省',
                'city_id' => '市',
                'city' => '市',
                'district_id' => '区',
                'district' => '区',
                'address' => '地址',
                'address2' => '地址2',
                'postcode' => '邮编',
                'mobile' => '手机',
                'email' => '邮箱',
                'distance' => '距离',
                'remark' => '备注',
                'payment_method' => '支付方式',
                'payment_fee' => '支付手续费',
                'payment_status' => '支付状态',
                'paid_at' => '支付时间',
                'shipment_id' => '配送公司',
                'shipment_name' => '配送名称',
                'shipment_fee' => '配送费',
                'shipment_status' => '配送状态',
                'shipped_at' => '配送时间',
                'product_amount' => '商品总价',
                'amount' => '支付金额',
                'number' => '数量',
                'extra_fee' => '额外费用',
                'discount' => '优惠金额',
                'tax' => '税费',
                'invoice' => '发票',
                'type' => '类型',
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
    }
}
