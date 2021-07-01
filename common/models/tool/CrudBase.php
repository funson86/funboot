<?php

namespace common\models\tool;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%tool_crud}}" to add your code.
 *
 * @property Store $store
 */
class CrudBase extends BaseModel
{
    public $startedTime = '';
    public $endedTime = '';

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
            'name' => Yii::t('app', 'Name'),
            'brief' => Yii::t('app', 'Brief'),
            'time' => Yii::t('app', 'Time'),
            'date' => Yii::t('app', 'Date'),
            'started_at' => Yii::t('app', 'Started At'),
            'startedTime' => Yii::t('app', 'Started At'),
            'ended_at' => Yii::t('app', 'Ended At'),
            'endedTime' => Yii::t('app', 'Ended At'),
            'color' => Yii::t('app', 'Color'),
            'tag' => Yii::t('app', 'Tag'),
            'config' => Yii::t('app', 'Config'),
            'image' => Yii::t('app', 'Image'),
            'images' => Yii::t('app', 'Images'),
            'file' => Yii::t('app', 'File'),
            'files' => Yii::t('app', 'Files'),
            'location' => Yii::t('app', 'Location'),
            'markdown' => Yii::t('app', 'Markdown'),
            'content' => Yii::t('app', 'Content'),
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
