<?php

namespace common\models\mall;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%mall_product_sku}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property int $product_id 商品
 * @property string $attribute_value 属性值
 * @property string $thumb 缩略图
 * @property float $price 价格
 * @property float $market_price 市场价
 * @property float $cost_price 成本价
 * @property float $wholesale_price 拼团价
 * @property string $sku 库存编号
 * @property string $stock_code 仓库条码
 * @property int $stock 库存数量
 * @property float $weight 重量
 * @property float $volume 体积
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class ProductSku extends ProductSkuBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mall_product_sku}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'product_id', 'stock', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['product_id', 'sku'], 'required'],
            [['price', 'market_price', 'cost_price', 'wholesale_price', 'weight', 'volume'], 'number'],
            [['name', 'attribute_value', 'thumb', 'sku', 'stock_code'], 'string', 'max' => 255],
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
                'name' => '名称',
                'product_id' => '商品',
                'attribute_value' => '属性值',
                'thumb' => '缩略图',
                'price' => '价格',
                'market_price' => '市场价',
                'cost_price' => '成本价',
                'wholesale_price' => '拼团价',
                'sku' => '库存编号',
                'stock_code' => '仓库条码',
                'stock' => '库存数量',
                'weight' => '重量',
                'volume' => '体积',
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
                'name' => Yii::t('app', 'Name'),
                'product_id' => Yii::t('app', 'Product ID'),
                'attribute_value' => Yii::t('app', 'Attribute Value'),
                'thumb' => Yii::t('app', 'Thumb'),
                'price' => Yii::t('app', 'Price'),
                'market_price' => Yii::t('app', 'Market Price'),
                'cost_price' => Yii::t('app', 'Cost Price'),
                'wholesale_price' => Yii::t('app', 'Wholesale Price'),
                'sku' => Yii::t('app', 'Sku'),
                'stock_code' => Yii::t('app', 'Stock Code'),
                'stock' => Yii::t('app', 'Stock'),
                'weight' => Yii::t('app', 'Weight'),
                'volume' => Yii::t('app', 'Volume'),
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
