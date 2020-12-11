<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use Yii;

/**
 * This is the model base class for table "{{%base_message}}" to add your code.
 *
 * @property Store $store
 * @property MessageSend[] $messageSends
 */
class MessageBase extends BaseModel
{
    const TYPE_BOARD = 1;
    const TYPE_NOTICE = 2;
    const TYPE_PRIVATE = 3;
    const TYPE_FEEDBACK = 7;

    const SEND_TYPE_NONE = 0;
    const SEND_TYPE_NEW = 1;

    const SEND_TARGET_ALL = 1;
    const SEND_TARGET_USER = 2;

    public $sendUsers = [];

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

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getSendTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::SEND_TYPE_NEW => Yii::t('cons', 'SEND_TYPE_NEW'),
        ];

        if ($id === 0) {
            return Yii::t('app', 'SEND_TYPE_NONE');
        } elseif ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getSendTargetLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::SEND_TARGET_ALL => Yii::t('cons', 'SEND_TARGET_ALL'),
            self::SEND_TARGET_USER => Yii::t('cons', 'SEND_TARGET_USER'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = Yii::$app->dictSystem->getDict('message_type');

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
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'send_type' => Yii::t('app', 'Send Type'),
            'send_target' => Yii::t('app', 'Send Target'),
            'send_user' => Yii::t('app', 'Send User'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'sendUsers' => Yii::t('app', '指定用户'),
        ];
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
    public function getMessageSends()
    {
        return $this->hasMany(MessageSend::className(), ['message_id' => 'id']);
    }
}
