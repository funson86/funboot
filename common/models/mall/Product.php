<?php

namespace common\models\mall;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%mall_product}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $category_id 分类
 * @property string $name 名称
 * @property string $sku 库存编号
 * @property string $stock_code 仓库条码
 * @property int $stock 库存数量
 * @property int $stock_warning 库存预警
 * @property float $weight 重量
 * @property float $volume 体积
 * @property float $price 价格
 * @property float $market_price 市场价
 * @property float $cost_price 成本价
 * @property float $wholesale_price 拼团价
 * @property string $thumb 缩略图
 * @property string|null $images 图片
 * @property string|null $tags 标签
 * @property string|null $brief 简述
 * @property string|null $content 内容
 * @property string $seo_title 搜索优化标题
 * @property string $seo_keywords 关键词
 * @property string|null $seo_description 描述
 * @property int $brand_id 品牌
 * @property int $vendor_id 供应商
 * @property int $attribute_set_id 属性集
 * @property float $star 星级
 * @property int $sales 销量
 * @property int $click 浏览量
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Product extends ProductBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mall_product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'category_id', 'stock', 'stock_warning', 'brand_id', 'vendor_id', 'attribute_set_id', 'sales', 'click', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['category_id', 'name', 'sku'], 'required'],
            [['weight', 'volume', 'price', 'market_price', 'cost_price', 'wholesale_price', 'star'], 'number'],
            [['images', 'tags'], 'safe'],
            [['brief', 'content', 'seo_description'], 'string'],
            [['name', 'sku', 'stock_code', 'thumb', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
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
                'category_id' => '分类',
                'name' => '名称',
                'sku' => '库存编号',
                'stock_code' => '仓库条码',
                'stock' => '库存数量',
                'stock_warning' => '库存预警',
                'weight' => '重量',
                'volume' => '体积',
                'price' => '价格',
                'market_price' => '市场价',
                'cost_price' => '成本价',
                'wholesale_price' => '拼团价',
                'thumb' => '缩略图',
                'images' => '图片',
                'tags' => '标签',
                'brief' => '简述',
                'content' => '内容',
                'seo_title' => '搜索优化标题',
                'seo_keywords' => '关键词',
                'seo_description' => '描述',
                'brand_id' => '品牌',
                'vendor_id' => '供应商',
                'attribute_set_id' => '属性集',
                'star' => '星级',
                'sales' => '销量',
                'click' => '浏览量',
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
                'category_id' => Yii::t('app', 'Category ID'),
                'name' => Yii::t('app', 'Name'),
                'sku' => Yii::t('app', 'Sku'),
                'stock_code' => Yii::t('app', 'Stock Code'),
                'stock' => Yii::t('app', 'Stock'),
                'stock_warning' => Yii::t('app', 'Stock Warning'),
                'weight' => Yii::t('app', 'Weight'),
                'volume' => Yii::t('app', 'Volume'),
                'price' => Yii::t('app', 'Price'),
                'market_price' => Yii::t('app', 'Market Price'),
                'cost_price' => Yii::t('app', 'Cost Price'),
                'wholesale_price' => Yii::t('app', 'Wholesale Price'),
                'thumb' => Yii::t('app', 'Thumb'),
                'images' => Yii::t('app', 'Images'),
                'tags' => Yii::t('app', 'Tags'),
                'brief' => Yii::t('app', 'Brief'),
                'content' => Yii::t('app', 'Content'),
                'seo_title' => Yii::t('app', 'Seo Title'),
                'seo_keywords' => Yii::t('app', 'Seo Keywords'),
                'seo_description' => Yii::t('app', 'Seo Description'),
                'brand_id' => Yii::t('app', 'Brand ID'),
                'vendor_id' => Yii::t('app', 'Vendor ID'),
                'attribute_set_id' => Yii::t('app', 'Attribute Set ID'),
                'star' => Yii::t('app', 'Star'),
                'sales' => Yii::t('app', 'Sales'),
                'click' => Yii::t('app', 'Click'),
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
