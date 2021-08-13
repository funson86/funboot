<?php

namespace common\models\chat;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%chat_log}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $room_id 聊天室
 * @property string $from_client_id 发送用户
 * @property string $to_client_id 接收用户
 * @property string $name 昵称
 * @property string|null $content 内容
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Log extends LogBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chat_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'room_id', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['content'], 'string'],
            [['from_client_id', 'to_client_id', 'name'], 'string', 'max' => 255],
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
                'room_id' => '聊天室',
                'from_client_id' => '发送用户',
                'to_client_id' => '接收用户',
                'name' => '昵称',
                'content' => '内容',
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
                'room_id' => Yii::t('app', 'Room ID'),
                'from_client_id' => Yii::t('app', 'From Client ID'),
                'to_client_id' => Yii::t('app', 'To Client ID'),
                'name' => Yii::t('app', 'Name'),
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
}
