<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%base_message}}" to add your code.
 *
 * @property User $user
 * @property MessageType $messageType
 * @property Store $store
 * @property User $from
 */
class MessageBase extends BaseModel
{
    const STATUS_READ = 1;
    const STATUS_UNREAD = 0;
    const STATUS_RECYCLE = -1;

    const TYPE_TEXT = 1;
    const TYPE_JSON = 2;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['message_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MessageType::className(), 'targetAttribute' => ['message_type_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
            [['from_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_id' => 'id']],
        ];
    }


    /**
     * return label or labels array
     * @param null $id
     * @param bool $flip
     * @param bool $all
     * @return array|mixed
     */
    public static function getStatusLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::STATUS_READ => Yii::t('cons', 'STATUS_READ'),
            self::STATUS_UNREAD => Yii::t('cons', 'STATUS_UNREAD'),
            self::STATUS_RECYCLE => Yii::t('cons', 'STATUS_RECYCLE'),
        ];

        $all && $data += [
            self::STATUS_DELETED => Yii::t('cons', 'STATUS_DELETED'),
        ];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'from_id' => Yii::t('app', 'From ID'),
            'message_type_id' => Yii::t('app', 'Message Type ID'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageType()
    {
        return $this->hasOne(MessageType::className(), ['id' => 'message_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'from_id']);
    }

    /**
     * @param $name
     * @param null $content
     * @param null $userId
     * @param null $fromId
     * @param null $messageId
     * @return bool|Message
     * @throws \yii\base\InvalidConfigException
     */
    public static function create($name, $content = null, $userId = null, $fromId = null, $messageId = null)
    {
        $model = new Message();
        $model->name = $name;
        $model->user_id = $userId ?? Yii::$app->storeSystem->getUserId();

        // store id首先应该给和user所在store，有可能是发给管理员
        $user = User::findOne($userId);
        $model->store_id = $user ? $user->store_id : Yii::$app->storeSystem->getId();

        $model->from_id = $fromId ?? Yii::$app->params['defaultUserId'];
        $model->message_type_id = $messageId ?? Yii::$app->params['defaultFeedbackMessageTypeId'];

        // 处理内容
        if (is_array($content) && count($content) > 0) {
            $model->type = self::TYPE_JSON;
            $model->content = json_encode($content);
        } else {
            $model->type = self::TYPE_TEXT;
            $model->content = htmlspecialchars($content);
        }

        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return false;
        }
        return $model;
    }
}
