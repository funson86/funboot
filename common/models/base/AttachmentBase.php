<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%base_attachment}}" to add your code.
 *
 * @property Store $store
 */
class AttachmentBase extends BaseModel
{

    const UPLOAD_TYPE_IMAGE = 'image';
    const UPLOAD_TYPE_FILE = 'file';
    const UPLOAD_TYPE_VIDEO = 'video';
    const UPLOAD_TYPE_VOICE = 'voice';

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
    public static function getUploadTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::UPLOAD_TYPE_IMAGE => Yii::t('cons', 'UPLOAD_TYPE_IMAGE'),
            self::UPLOAD_TYPE_FILE => Yii::t('cons', 'UPLOAD_TYPE_FILE'),
            self::UPLOAD_TYPE_VIDEO => Yii::t('cons', 'UPLOAD_TYPE_VIDEO'),
            self::UPLOAD_TYPE_VOICE => Yii::t('cons', 'UPLOAD_TYPE_VOICE'),
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
            'driver' => Yii::t('app', 'Driver'),
            'upload_type' => Yii::t('app', 'Upload Type'),
            'file_type' => Yii::t('app', 'File Type'),
            'path' => Yii::t('app', 'Path'),
            'url' => Yii::t('app', 'Url'),
            'md5' => Yii::t('app', 'Md5'),
            'size' => Yii::t('app', 'Size'),
            'ext' => Yii::t('app', 'Ext'),
            'year' => Yii::t('app', 'Year'),
            'month' => Yii::t('app', 'Month'),
            'day' => Yii::t('app', 'Day'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'ip' => Yii::t('app', 'Ip'),
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
     *
     * @param  integer $id
     * @return string | array
     */
    public static function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        $model = new Attachment();
        $model->attributes = $data;
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return false;
        }

        return $model;
    }
}
