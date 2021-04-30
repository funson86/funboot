<?php

namespace common\models\mall;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%mall_order_product}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $parent_id 父节点
 * @property int $user_id 用户
 * @property int $order_id 订单
 * @property int $product_id 商品
 * @property string $product_attribute_value 属性值
 * @property string $name 名称
 * @property string $sku 库存编码
 * @property int $number 数量
 * @property float $price 价格
 * @property float $market_price 市场价
 * @property float $cost_price 成本价
 * @property float $wholesale_price 拼团价
 * @property string $thumb 图片
 * @property int $cart_id 购物车ID
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class OrderProduct extends OrderProductBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mall_order_product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'parent_id', 'user_id', 'order_id', 'product_id', 'number', 'cart_id', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_id', 'order_id', 'product_id', 'sku'], 'required'],
            [['price', 'market_price', 'cost_price', 'wholesale_price'], 'number'],
            [['product_attribute_value', 'name', 'sku', 'thumb'], 'string', 'max' => 255],
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
                'parent_id' => '父节点',
                'user_id' => '用户',
                'order_id' => '订单',
                'product_id' => '商品',
                'product_attribute_value' => '属性值',
                'name' => '名称',
                'sku' => '库存编码',
                'number' => '数量',
                'price' => '价格',
                'market_price' => '市场价',
                'cost_price' => '成本价',
                'wholesale_price' => '拼团价',
                'thumb' => '图片',
                'cart_id' => '购物车ID',
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
                'parent_id' => Yii::t('app', 'Parent ID'),
                'user_id' => Yii::t('app', 'User ID'),
                'order_id' => Yii::t('app', 'Order ID'),
                'product_id' => Yii::t('app', 'Product ID'),
                'product_attribute_value' => Yii::t('app', 'Product Attribute Value'),
                'name' => Yii::t('app', 'Name'),
                'sku' => Yii::t('app', 'Sku'),
                'number' => Yii::t('app', 'Number'),
                'price' => Yii::t('app', 'Price'),
                'market_price' => Yii::t('app', 'Market Price'),
                'cost_price' => Yii::t('app', 'Cost Price'),
                'wholesale_price' => Yii::t('app', 'Wholesale Price'),
                'thumb' => Yii::t('app', 'Thumb'),
                'cart_id' => Yii::t('app', 'Cart ID'),
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
