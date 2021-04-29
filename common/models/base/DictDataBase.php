<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use Yii;

/**
 * This is the model base class for table "{{%base_dict_data}}" to add your code.
 *
 * @property Dict $dict
 * @property Store $store
 */
class DictDataBase extends BaseModel
{

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['dict_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dict::className(), 'targetAttribute' => ['dict_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'dict_id' => Yii::t('app', 'Dict ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'brief' => Yii::t('app', 'Brief'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDict()
    {
        return $this->hasOne(Dict::className(), ['id' => 'dict_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }
}
