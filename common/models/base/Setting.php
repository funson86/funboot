<?php

namespace common\models\base;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%base_setting}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $app_id 子系统
 * @property int $setting_type_id 配置类型
 * @property string $name 名称
 * @property string $code 代码
 * @property string|null $value 值
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Setting extends SettingBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'setting_type_id', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'code'], 'required'],
            [['value'], 'string'],
            [['app_id', 'name', 'code'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'store_id' => '商家',
            'app_id' => '子系统',
            'setting_type_id' => '配置类型',
            'name' => '名称',
            'code' => '代码',
            'value' => '值',
            'type' => '类型',
            'sort' => '排序',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'created_by' => '创建用户',
            'updated_by' => '更新用户',
        ]);
    }
}
