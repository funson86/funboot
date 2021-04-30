<?php

namespace common\models\bbs;

use common\helpers\ArrayHelper;
use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model base class for table "fb_bbs_raw" to add your code.
 *
 * @property Store $store
 */
class RawBase extends BaseModel
{
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

    public function behaviors()
    {
        // 未登录认为是store管理员登录, console下不一定有Yii::$app->user
        $userId = isset(Yii::$app->user) && !Yii::$app->user->getIsGuest() ? Yii::$app->user->id : Yii::$app->storeSystem->getUserId();
        return ArrayHelper::merge([], [
            [
                'class' => TimestampBehavior::class,  // 行为类
                'attributes' => [
                    // 当insert时,自动把当前时间戳填充填充指定的属性(created_at),
                    // 当然, 以下键值也可以是数组,
                    // eg: ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_INSERT => [],
                    // 当update时,自动把当前时间戳填充指定的属性(updated_at)
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ]);
    }


    /** add function getXxxLabels here, detail in BaseModel **/

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'node_id' => 'Node ID',
            'node_ids' => 'Node Ids',
            'name' => 'Name',
            'brief' => 'Brief',
            'content' => 'Content',
            'url' => 'Url',
            'type' => 'Type',
            'sort' => 'Sort',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

}
