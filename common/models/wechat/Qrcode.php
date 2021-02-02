<?php

namespace common\models\wechat;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%wechat_qrcode}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property string $keyword 关联关键字
 * @property int $scene_id 场景ID
 * @property string $scene_str 场景值
 * @property int $expired_second 过期秒数
 * @property int $expired_at 截止时间
 * @property string $ticket 微信凭证
 * @property int $subscribe_count 扫描次数
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Qrcode extends QrcodeBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wechat_qrcode}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'scene_id', 'expired_second', 'expired_at', 'subscribe_count', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['name', 'keyword', 'scene_str', 'ticket'], 'string', 'max' => 255],
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
                'keyword' => '关联关键字',
                'scene_id' => '场景ID',
                'scene_str' => '场景值',
                'expired_second' => '过期秒数',
                'expired_at' => '截止时间',
                'ticket' => '微信凭证',
                'subscribe_count' => '扫描次数',
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
            ]);
        }
    }
}
