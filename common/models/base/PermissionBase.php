<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use Yii;

/**
 * This is the model base class for table "{{%base_permission}}" to add your code.
 *
 * @property Store $store
 * @property RolePermission[] $baseRolePermissions
 */
class PermissionBase extends BaseModel
{
    const TARGET_SELF = 0;
    const TARGET_NEW = 1;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTargetLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TARGET_SELF => Yii::t('cons', 'NO'),
            self::TARGET_NEW => Yii::t('cons', 'YES'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolePermissions()
    {
        return $this->hasMany(RolePermission::className(), ['permission_id' => 'id']);
    }

}
