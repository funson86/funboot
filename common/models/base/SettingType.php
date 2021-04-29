<?php

namespace common\models\base;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%base_setting_type}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $parent_id 父节点
 * @property string $app_id 子系统
 * @property string $name 名称
 * @property string $code 代码
 * @property string $brief 简介
 * @property string $type 类型
 * @property string $value_range 可选值
 * @property string $value_default 默认值
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class SettingType extends SettingTypeBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_setting_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'parent_id', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'code'], 'required'],
            [['app_id', 'name', 'code', 'brief', 'type', 'value_range', 'value_default'], 'string', 'max' => 255],
            [['code'], 'unique'],
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
                'parent_id' => '父节点',
                'app_id' => '子系统',
                'name' => '名称',
                'code' => '代码',
                'brief' => '简介',
                'type' => '类型',
                'value_range' => '可选值',
                'value_default' => '默认值',
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
                'parent_id' => Yii::t('app', 'Parent ID'),
                'app_id' => Yii::t('app', 'App ID'),
                'name' => Yii::t('app', 'Name'),
                'code' => Yii::t('app', 'Code'),
                'brief' => Yii::t('app', 'Brief'),
                'type' => Yii::t('app', 'Type'),
                'value_range' => Yii::t('app', 'Value Range'),
                'value_default' => Yii::t('app', 'Value Default'),
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
