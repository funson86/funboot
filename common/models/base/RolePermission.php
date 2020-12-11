<?php

namespace common\models\base;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%base_role_permission}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property int $role_id 角色
 * @property int $permission_id 权限
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class RolePermission extends RolePermissionBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_role_permission}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'role_id', 'permission_id', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['role_id', 'permission_id'], 'required'],
            [['name'], 'string', 'max' => 255],
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
            'name' => '名称',
            'role_id' => '角色',
            'permission_id' => '权限',
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
