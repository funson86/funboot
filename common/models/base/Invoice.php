<?php

namespace common\models\base;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%base_invoice}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $user_id 用户
 * @property string $name 名称
 * @property string $address 地址
 * @property string $mobile 手机
 * @property string $tax_no 税号
 * @property string|null $content 内容
 * @property float $amount 金额
 * @property string $remark 备注
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Invoice extends InvoiceBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_invoice}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'user_id', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_id', 'name'], 'required'],
            [['content'], 'string'],
            [['amount'], 'number'],
            [['name', 'address', 'mobile', 'tax_no', 'remark'], 'string', 'max' => 255],
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
                'address' => '地址',
                'mobile' => '手机',
                'tax_no' => '税号',
                'content' => '内容',
                'amount' => '金额',
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
                'address' => Yii::t('app', 'Address'),
                'mobile' => Yii::t('app', 'Mobile'),
                'tax_no' => Yii::t('app', 'Tax No'),
                'content' => Yii::t('app', 'Content'),
                'amount' => Yii::t('app', 'Amount'),
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
