<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "{{%store}}".
 *
 * @property int $id
 * @property int $user_id 管理员
 * @property string $name 名称
 * @property string $description 简介
 * @property string $host_name 域名
 * @property string $route 子系统
 * @property int $expired_at 到期时间
 * @property string|null $remark 备注
 * @property int $language 语言
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Store extends StoreBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%store}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['user_id', 'expired_at', 'language', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['remark'], 'string'],
            [['name', 'description', 'host_name', 'route'], 'string', 'max' => 255],
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
                'user_id' => '管理员',
                'name' => '名称',
                'description' => '简介',
                'host_name' => '域名',
                'route' => '子系统',
                'expired_at' => '到期时间',
                'remark' => '备注',
                'language' => '语言',
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
                'user_id' => Yii::t('app', 'User ID'),
                'name' => Yii::t('app', 'Name'),
                'description' => Yii::t('app', 'Description'),
                'host_name' => Yii::t('app', 'Host Name'),
                'route' => Yii::t('app', 'Route'),
                'expired_at' => Yii::t('app', 'Expired At'),
                'remark' => Yii::t('app', 'Remark'),
                'language' => Yii::t('app', 'Language'),
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
