<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%base_message_type}}" to add your code.
 *
 * @property Message[] $baseMessages
 * @property Store $store
 */
class MessageTypeBase extends BaseModel
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
    public $sendTypes = [];

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
            return Yii::t('cons', 'SEND_TYPE_NONE');
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
     * @param bool $all
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

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_BOARD => Yii::t('cons', 'TYPE_BOARD'),
            self::TYPE_NOTICE => Yii::t('cons', 'TYPE_NOTICE'),
            self::TYPE_PRIVATE => Yii::t('cons', 'TYPE_PRIVATE'),
            self::TYPE_FEEDBACK => Yii::t('cons', 'TYPE_FEEDBACK'),
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
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'send_type' => Yii::t('app', 'Send Type'),
            'sendTypes' => Yii::t('app', 'Send Type'),
            'send_target' => Yii::t('app', 'Send Target'),
            'send_user' => Yii::t('app', 'Send User'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'sendUsers' => Yii::t('app', 'Send Users'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['message_type_id' => 'id']);
    }

}
