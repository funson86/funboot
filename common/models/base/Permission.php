<?php

namespace common\models\base;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%base_permission}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $parent_id 父节点
 * @property string $name 名称
 * @property string $app_id 子系统
 * @property string $brief 简介
 * @property string $path 路径
 * @property string $icon 图标
 * @property string $tree 树路径
 * @property int $level 层级
 * @property int $target 新窗口打开
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Permission extends PermissionBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_permission}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'parent_id', 'level', 'target', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['name', 'app_id', 'brief', 'path', 'icon'], 'string', 'max' => 255],
            [['tree'], 'string', 'max' => 1022],
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
                'name' => '名称',
                'app_id' => '子系统',
                'brief' => '简介',
                'path' => '路径',
                'icon' => '图标',
                'tree' => '树路径',
                'level' => '层级',
                'target' => '新窗口打开',
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
                'parent_id' => Yii::t('app', 'Parent ID'),
                'name' => Yii::t('app', 'Name'),
                'app_id' => Yii::t('app', 'App ID'),
                'brief' => Yii::t('app', 'Brief'),
                'path' => Yii::t('app', 'Path'),
                'icon' => Yii::t('app', 'Icon'),
                'tree' => Yii::t('app', 'Tree'),
                'level' => Yii::t('app', 'Level'),
                'target' => Yii::t('app', 'Target'),
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
