<?php

namespace common\models\tool;

use common\models\Store;
use common\models\User;
use Yii;
use \yii\mongodb\ActiveRecord;

/**
 * This is the model base class for mongodb "{{mongodb_crud}}" to add your code.
 *
 * @property Store $store
 */
class MongodbCrudBase extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_EXPIRED = -1;
    const STATUS_DELETED = -10;

    const TYPE_DEFAULT = 1;
    const TYPE_B = 2;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['_id'], 'safe'],
        ];
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
     * return label or labels array
     * @param null $id
     * @param bool $flip
     * @param bool $all
     * @return array|mixed
     */
    public static function getStatusLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::STATUS_ACTIVE => Yii::t('cons', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('cons', 'STATUS_INACTIVE'),
        ];

        $all && $data += [
            self::STATUS_EXPIRED => Yii::t('cons', 'STATUS_EXPIRED'),
            self::STATUS_DELETED => Yii::t('cons', 'STATUS_DELETED'),
        ];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_DEFAULT => Yii::t('cons', 'TYPE_DEFAULT'),
            self::TYPE_B => Yii::t('cons', 'TYPE_B'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }
}
