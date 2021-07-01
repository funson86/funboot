<?php

namespace common\models\mall;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%mall_product}}" to add your code.
 *
 * @property Category $category
 * @property Store $store
 */
class ProductBase extends BaseModel
{
    public $isAttribute = 1;
    public $types = [];
    public $tags = [];

    const TYPE_HOT = 1;
    const TYPE_NEW = 2;
    const TYPE_PROMOTION = 4;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /** add function getXxxLabels here, detail in BaseModel **/
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
            self::TYPE_HOT => Yii::t('cons', 'TYPE_HOT'),
            self::TYPE_NEW => Yii::t('cons', 'TYPE_NEW'),
            self::TYPE_PROMOTION => Yii::t('cons', 'TYPE_PROMOTION'),
        ];

        $all && $data += [];

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
            'param_id' => Yii::t('app', 'Param ID'),
            'star' => Yii::t('app', 'Star'),
            'sales' => Yii::t('app', 'Sales'),
            'click' => Yii::t('app', 'Click'),
            'type' => Yii::t('app', 'Type'),
            'types' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'isAttribute' => Yii::t('app', 'Is Multiple Attribute'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRanksPassed()
    {
        return $this->hasMany(Rank::className(), ['product_id' => 'id'])->where(['status' => Rank::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRanksPassedGood()
    {
        return $this->hasMany(Rank::className(), ['product_id' => 'id'])->where(['and', 'status =' . Rank::STATUS_ACTIVE, 'star >= 4'])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRanksPassedNormal()
    {
        return $this->hasMany(Rank::className(), ['product_id' => 'id'])->where(['and', 'status =' . Rank::STATUS_ACTIVE, 'star >= 2', 'star <= 3'])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRanksPassedBad()
    {
        return $this->hasMany(Rank::className(), ['product_id' => 'id'])->where(['status' => Rank::STATUS_ACTIVE, 'star' => 1])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultations()
    {
        return $this->hasMany(Consultation::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultationsSortTime()
    {
        return $this->hasMany(Consultation::className(), ['product_id' => 'id'])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultationsPassed()
    {
        return $this->hasMany(Consultation::className(), ['product_id' => 'id'])->where(['status' => Consultation::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC]);
    }

}
