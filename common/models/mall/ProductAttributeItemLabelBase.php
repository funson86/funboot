<?php

namespace common\models\mall;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%mall_product_attribute_item_label}}" to add your code.
 *
 * @property Product $product
 * @property Store $store
 * @property AttributeItem $attributeItem
 */
class ProductAttributeItemLabelBase extends BaseModel
{
    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
            [['attribute_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeItem::className(), 'targetAttribute' => ['attribute_item_id' => 'id']],
        ];
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
            'name' => Yii::t('app', 'Name'),
            'product_id' => Yii::t('app', 'Product ID'),
            'attribute_item_id' => Yii::t('app', 'Attribute Item ID'),
            'label' => Yii::t('app', 'Label'),
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
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeItem()
    {
        return $this->hasOne(AttributeItem::className(), ['id' => 'attribute_item_id']);
    }

}
