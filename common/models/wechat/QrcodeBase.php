<?php

namespace common\models\wechat;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%wechat_qrcode}}" to add your code.
 *
 * @property Store $store
 */
class QrcodeBase extends BaseModel
{
    public $url;

    const TYPE_TEMP = 1;
    const TYPE_PERM = 2;

    const SCENE_MAX_VALUE = 100000;

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
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_TEMP => Yii::t('cons', 'TYPE_TEMP'),
            self::TYPE_PERM => Yii::t('cons', 'TYPE_PERM'),
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
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Qrcode'),
            'store_id' => Yii::t('app', 'Store ID'),
            'name' => Yii::t('app', 'Name'),
            'keyword' => Yii::t('app', 'Keyword'),
            'scene_id' => Yii::t('app', 'Scene ID'),
            'scene_str' => Yii::t('app', 'Scene Str'),
            'expired_second' => Yii::t('app', 'Expired Second'),
            'expired_at' => Yii::t('app', 'Expired At'),
            'ticket' => Yii::t('app', 'Ticket'),
            'subscribe_count' => Yii::t('app', 'Subscribe Count'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }


}
