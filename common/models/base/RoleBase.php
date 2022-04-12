<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use Yii;

/**
 * This is the model base class for table "{{%base_role}}" to add your code.
 *
 * @property Store $store
 * @property RolePermission[] $rolePermissions
 * @property UserRole[] $userRoles
 */
class RoleBase extends BaseModel
{
    /*const TYPE_SUPER_ADMIN = 10;
    const TYPE_ADMIN = 20;
    const TYPE_STORE = 30;
    const TYPE_USER = 60;*/

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
    * @param  integer $id
    * @return string | array
    */
    /*public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_SUPER_ADMIN => Yii::t('cons', 'TYPE_SUPER_ADMIN'),
            self::TYPE_ADMIN => Yii::t('cons', 'TYPE_ADMIN'),
            self::TYPE_STORE => Yii::t('cons', 'TYPE_STORE'),
            self::TYPE_USER => Yii::t('cons', 'TYPE_USER'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }*/

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'name' => Yii::t('app', 'Name'),
            'is_default' => Yii::t('app', 'Is Default'),
            'brief' => Yii::t('app', 'Brief'),
            'tree' => Yii::t('app', 'Tree'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolePermissions()
    {
        return $this->hasMany(RolePermission::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::className(), ['role_id' => 'id']);
    }

    /**
     * @return RoleBase|null
     */
    public static function getDefaultSuperAdminRole()
    {
        return self::findOne(1);
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function getDefaultAdminRole()
    {
        list($start, $end) = Yii::$app->authSystem->getAdminRoleIdRange();
        return self::find()->where(['between', 'id', $start, $end])->one();
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function getDefaultStoreRole()
    {
        list($start, $end) = Yii::$app->authSystem->getStoreRoleIdRange();
        return self::find()->where(['between', 'id', $start, $end])->one();
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function getDefaultStoreRoleId()
    {
        $model = self::getDefaultStoreRole();
        return $model->id ?? Yii::$app->params['defaultStoreRoleId'];
    }
}
