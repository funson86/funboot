<?php

namespace backend\modules\base\controllers;

use common\components\enums\YesNo;
use common\helpers\ArrayHelper;
use common\models\base\Department;
use common\models\base\Permission;
use common\models\base\RoleDepartment;
use common\models\base\RolePermission;
use http\Exception\InvalidArgumentException;
use Yii;
use common\models\base\Role;
use backend\controllers\BaseController;
use yii\base\NotSupportedException;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
* Role
*
* Class RoleController
* @package backend\modules\base\controllers
*/
class RoleController extends BaseController
{
    /**
    * @var Role
    */
    public $modelClass = Role::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name', 'brief'];

    /**
     * 可编辑字段
     *
     * @var int
     */
    protected $editAjaxFields = ['name', 'sort'];

    /**
     * 导入导出字段
     *
     * @var int
     */
    protected $exportFields = [
        'id' => 'text',
        'name' => 'text',
        'type' => 'select',
    ];

    protected function beforeEditSave($id = null, $model = null)
    {
        if (!$id) {
            $id = $this->getId(Yii::$app->request->get('type'));
            if ($id) {
                $model->id = $id;
            }
        }

        return true;
    }

    protected function afterEdit($id = null, $model = null)
    {
        if ($model->is_default == YesNo::YES) {
            if ($model->id > Yii::$app->authSystem->maxStoreRoleId) { // 普通用户
                $this->modelClass::updateAll(['is_default' => YesNo::NO], 'id <>' . $model->id . ' and id > ' . Yii::$app->authSystem->maxStoreRoleId);
            } elseif ($model->id <= Yii::$app->authSystem->maxAdminRoleId) { // 店铺角色
                $this->modelClass::updateAll(['is_default' => YesNo::NO], 'id <>' . $model->id . ' and id > 1 and id < ' . Yii::$app->authSystem->maxAdminRoleId);
            } else { // 管理员
                $this->modelClass::updateAll(['is_default' => YesNo::NO], 'id <>' . $model->id . ' and id > ' . Yii::$app->authSystem->maxAdminRoleId . ' and id <= ' . Yii::$app->authSystem->maxStoreRoleId);
            }
        }
    }

    /**
     * ajax编辑/创建
     *
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionEditAjaxPermission()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        // 先标注为不可用，再更新已有的，新建没有的，最后删除不可用的。
        if (Yii::$app->request->isPost) {
            RolePermission::updateAll(['status' => RolePermission::STATUS_INACTIVE], ['role_id' => $id]);

            $treeIds = Yii::$app->request->post('tree_ids');
            if (strlen($treeIds) > 0) {
                $arrTreeId = explode(',', $treeIds);
                foreach ($arrTreeId as $treeId) {
                    $rolePermission = RolePermission::find()->where(['role_id' => $id, 'permission_id' => $treeId])->one();
                    if ($rolePermission) {
                        $rolePermission->status = RolePermission::STATUS_ACTIVE;
                    } else {
                        $rolePermission = new RolePermission();
                        $rolePermission->role_id = $id;
                        $rolePermission->permission_id = $treeId;
                    }
                    $rolePermission->save();
                }
            }

            RolePermission::deleteAll(['status' => RolePermission::STATUS_INACTIVE, 'role_id' => $id]);

            return $this->redirectSuccess();
        }

        $permissions = Permission::find()->asArray()->all();
        $selectIds = ArrayHelper::getColumn(RolePermission::find()->where(['role_id' => $id])->all(), 'permission_id');
        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'permissions' => $permissions,
            'selectIds' => $selectIds,
        ]);
    }

    /**
     * ajax编辑/创建
     *
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionEditAjaxDepartment()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        // 先标注为不可用，再更新已有的，新建没有的，最后删除不可用的。
        if (Yii::$app->request->isPost) {
            RoleDepartment::updateAll(['status' => RoleDepartment::STATUS_INACTIVE], ['role_id' => $id]);

            $treeIds = Yii::$app->request->post('tree_ids');
            if (strlen($treeIds) > 0) {
                $arrTreeId = explode(',', $treeIds);
                foreach ($arrTreeId as $treeId) {
                    $roleDepartment = RoleDepartment::find()->where(['role_id' => $id, 'department_id' => $treeId])->one();
                    if ($roleDepartment) {
                        $roleDepartment->status = RoleDepartment::STATUS_ACTIVE;
                    } else {
                        $roleDepartment = new RoleDepartment();
                        $roleDepartment->role_id = $id;
                        $roleDepartment->department_id = $treeId;
                    }
                    $roleDepartment->save();
                }
            }

            RoleDepartment::deleteAll(['status' => RoleDepartment::STATUS_INACTIVE, 'role_id' => $id]);

            return $this->redirectSuccess();
        }

        $departments = Department::find()->asArray()->all();
        $selectIds = ArrayHelper::getColumn(RoleDepartment::find()->where(['role_id' => $id])->all(), 'department_id');
        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'departments' => $departments,
            'selectIds' => $selectIds,
        ]);
    }

    protected function getId($type = null)
    {
        if (!$type) {
            return null;
        }

        return $type == 'admin' ? $this->findId(1, Yii::$app->authSystem->maxAdminRoleId)
            : $this->findId(Yii::$app->authSystem->maxAdminRoleId, Yii::$app->authSystem->maxStoreRoleId);
    }

    protected function findId($min, $max)
    {
        $roles = Role::find()->where(['>=', 'id', $min])->andWhere(['<=', 'id', $max])->all();
        $ids = ArrayHelper::getColumn($roles, 'id');

        for ($i = $min + 1; $i < $max; $i++) {
            if (!in_array((string)$i, $ids)) {
                return $i;
            }
        }

        return null;
    }
}
