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
 * @property string $name 名称
 * @property string $sn 编号
 * @property string $consignee 联系人
 * @property int $country_id 国家
 * @property int $province_id 省
 * @property int $city_id 市
 * @property int $district_id 区
 * @property string $state 国家
 * @property string $address 地址
 * @property string $address1 地址
 * @property string $address2 地址2
 * @property string $zipcode 邮编
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
            [['store_id', 'user_id', 'country_id', 'province_id', 'city_id', 'district_id', 'payment_method', 'payment_status', 'paid_at', 'shipment_id', 'shipment_status', 'shipped_at', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_id', 'sn'], 'required'],
            [['distance', 'payment_fee', 'shipment_fee', 'product_amount', 'amount', 'extra_fee', 'discount', 'tax'], 'number'],
            [['name', 'sn', 'consignee', 'state', 'address', 'address1', 'address2', 'zipcode', 'mobile', 'email', 'remark', 'shipment_name', 'invoice'], 'string', 'max' => 255],
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
                'sn' => '编号',
                'consignee' => '联系人',
                'country_id' => '国家',
                'province_id' => '省',
                'city_id' => '市',
                'district_id' => '区',
                'state' => '国家',
                'address' => '地址',
                'address1' => '地址',
                'address2' => '地址2',
                'zipcode' => '邮编',
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
            ]);
        }
    }
}
