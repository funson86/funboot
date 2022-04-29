<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%base_department}}" to add your code.
 *
 * @property Store $store
 */
class DepartmentBase extends BaseModel
{

    /**
     * @var array
     */
    public $heads = [];

    /**
     * @var array
     */
    public $viceHeads = [];

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'app_id' => Yii::t('app', 'App ID'),
            'brief' => Yii::t('app', 'Brief'),
            'head' => Yii::t('app', 'Head'),
            'vice_head' => Yii::t('app', 'Vice Head'),
            'level' => Yii::t('app', 'Level'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'heads' => Yii::t('app', 'Head'),
            'viceHeads' => Yii::t('app', 'Vice Head'),
        ]);
    }

}
