<?php

namespace common\models\base;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%base_attachment}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property string $driver 存储位置
 * @property string $upload_type 上传类型
 * @property string $file_type 文件类型
 * @property string $path 本地路径
 * @property string $url Url地址
 * @property string $md5 Md5值
 * @property int $size 文件大小
 * @property string $ext 后缀
 * @property int $year 年份
 * @property int $month 月份
 * @property int $day 日
 * @property int $width 宽度
 * @property int $height 高度
 * @property string $ip 上传IP
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Attachment extends AttachmentBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_attachment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'size', 'year', 'month', 'day', 'width', 'height', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'driver', 'upload_type', 'file_type', 'path', 'url', 'md5', 'ext', 'ip'], 'string', 'max' => 255],
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
                'name' => '名称',
                'driver' => '存储位置',
                'upload_type' => '上传类型',
                'file_type' => '文件类型',
                'path' => '本地路径',
                'url' => 'Url地址',
                'md5' => 'Md5值',
                'size' => '文件大小',
                'ext' => '后缀',
                'year' => '年份',
                'month' => '月份',
                'day' => '日',
                'width' => '宽度',
                'height' => '高度',
                'ip' => '上传IP',
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
    }
}
