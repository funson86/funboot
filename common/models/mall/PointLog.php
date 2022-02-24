<?php

namespace common\models\mall;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%mall_point_log}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $user_id 用户
 * @property string $name 名称
 * @property int $point 积分
 * @property int $original 原值
 * @property int $balance 余额
 * @property string $remark 备注
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class PointLog extends PointLogBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mall_point_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'user_id', 'point', 'original', 'balance', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_id'], 'required'],
            [['name', 'remark'], 'string', 'max' => 255],
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
                'user_id' => '用户',
                'name' => '名称',
                'point' => '积分',
                'original' => '原值',
                'balance' => '余额',
                'remark' => '备注',
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
                'user_id' => Yii::t('app', 'User ID'),
                'name' => Yii::t('app', 'Name'),
                'point' => Yii::t('app', 'Point'),
                'original' => Yii::t('app', 'Original'),
                'balance' => Yii::t('app', 'Balance'),
                'remark' => Yii::t('app', 'Remark'),
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
