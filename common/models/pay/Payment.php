<?php

namespace common\models\pay;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%pay_payment}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $bank_code 支付方式
 * @property float $money 捐赠金额
 * @property string $name 昵称
 * @property string $email 邮箱
 * @property string $email_exp 体验管理员邮箱
 * @property string $remark 留言
 * @property string $sn 序列号
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Payment extends PaymentBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pay_payment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['money'], 'number'],
            [['name'], 'required'],
            [['bank_code', 'name', 'email', 'email_exp', 'remark', 'sn'], 'string', 'max' => 255],
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
                'bank_code' => '支付方式',
                'money' => '捐赠金额',
                'name' => '昵称',
                'email' => '邮箱',
                'email_exp' => '体验管理员邮箱',
                'remark' => '留言',
                'sn' => '序列号',
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
                'bank_code' => Yii::t('app', 'Bank Code'),
                'money' => Yii::t('app', 'Money'),
                'name' => Yii::t('app', 'Name'),
                'email' => Yii::t('app', 'Email'),
                'email_exp' => Yii::t('app', 'Email Exp'),
                'remark' => Yii::t('app', 'Remark'),
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
