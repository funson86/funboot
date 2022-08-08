<?php

namespace common\models\base;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%base_recharge}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $user_id 用户
 * @property string $name 名称
 * @property string $sn 编号
 * @property string $mobile 手机
 * @property string $email 邮箱
 * @property string $remark 备注
 * @property int $payment_method 支付方式
 * @property int $payment_status 支付状态
 * @property int $paid_at 支付时间
 * @property float $amount 支付金额
 * @property float $tax 税费
 * @property string $invoice 发票
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Recharge extends RechargeBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_recharge}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'user_id', 'payment_method', 'payment_status', 'paid_at', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_id', 'sn'], 'required'],
            [['amount', 'tax'], 'number'],
            [['name', 'sn', 'mobile', 'email', 'remark', 'invoice'], 'string', 'max' => 255],
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
                'sn' => '编号',
                'mobile' => '手机',
                'email' => '邮箱',
                'remark' => '备注',
                'payment_method' => '支付方式',
                'payment_status' => '支付状态',
                'paid_at' => '支付时间',
                'amount' => '支付金额',
                'tax' => '税费',
                'invoice' => '发票',
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
                'sn' => Yii::t('app', 'Sn'),
                'mobile' => Yii::t('app', 'Mobile'),
                'email' => Yii::t('app', 'Email'),
                'remark' => Yii::t('app', 'Remark'),
                'payment_method' => Yii::t('app', 'Payment Method'),
                'payment_status' => Yii::t('app', 'Payment Status'),
                'paid_at' => Yii::t('app', 'Paid At'),
                'amount' => Yii::t('app', 'Amount'),
                'tax' => Yii::t('app', 'Tax'),
                'invoice' => Yii::t('app', 'Invoice'),
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
