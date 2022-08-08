<?php

namespace common\models\mall;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%mall_coupon_type}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property string $money 优惠金额
 * @property float $min_amount 最低金额
 * @property int $max_times 最大数量
 * @property int $started_at 开始时间
 * @property int $ended_at 结束时间
 * @property string $sn 编号
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class CouponType extends CouponTypeBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mall_coupon_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'max_times', 'started_at', 'ended_at', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['money', 'started_at', 'ended_at'], 'required'],
            [['min_amount'], 'number'],
            [['name', 'money', 'sn'], 'string', 'max' => 255],
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
                'money' => '优惠金额',
                'min_amount' => '最低金额',
                'max_times' => '最大数量',
                'started_at' => '开始时间',
                'ended_at' => '结束时间',
                'sn' => '编号',
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
                'money' => Yii::t('app', 'Money'),
                'min_amount' => Yii::t('app', 'Min Amount'),
                'max_times' => Yii::t('app', 'Max Times'),
                'started_at' => Yii::t('app', 'Started At'),
                'ended_at' => Yii::t('app', 'Ended At'),
                'sn' => Yii::t('app', 'Sn'),
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
