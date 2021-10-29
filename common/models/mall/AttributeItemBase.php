<?php

namespace common\models\mall;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%mall_attribute_item}}" to add your code.
 *
 * @property Attribute $attribute0
 * @property Store $store
 * @property ProductAttributeItemLabel[] $productAttributeItemLabels
 */
class AttributeItemBase extends BaseModel
{
    static $tableCode = 2530;

    static $mapLangFieldType = [
        'name' => 'text',
        'brief' => 'textarea',
    ];

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
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
            'attribute_id' => Yii::t('app', 'Attribute ID'),
            'name' => Yii::t('app', 'Name'),
            'brief' => Yii::t('app', 'Brief'),
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
    public function getAttribute0()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMallProductAttributeItemLabels()
    {
        return $this->hasMany(ProductAttributeItemLabel::className(), ['attribute_item_id' => 'id']);
    }

}
