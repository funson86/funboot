<?php

namespace common\components\base;

use common\helpers\ArrayHelper;
use common\helpers\AuthHelper;
use common\models\base\Permission;
use common\models\base\RolePermission;
use common\models\base\UserRole;
use common\models\User;
use common\services\base\UserPermission;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class AuthSystem
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class AuthSystem extends \yii\base\Component
{
    public $superAdminUsernames = [];
    public $maxSuperAdminRoleId = 1;
    public $maxAdminRoleId = 49;
    public $maxStoreRoleId = 99;

    /**
     * @var
     */
    public $allPermission = [];

    public $mapPermissionPathId = [];
    public $mapPermissionIdPath = [];

    public $treeAllPermission = [];

    public $userPermissionIds = [];
    public $userPermissions = [];
    public $userPermissionPaths = [];
    public $userPermissionsTree = [];

    /**
     * AuthSystem constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        // 获取所有权限
        $this->allPermission = Yii::$app->cacheSystem->getAllPermission();
        $this->mapPermissionPathId = ArrayHelper::map($this->allPermission, 'path', 'id');
        $this->mapPermissionIdPath = ArrayHelper::map($this->allPermission, 'id', 'path');
        $this->treeAllPermission = ArrayHelper::tree($this->allPermission, 0, true);

        // 计算用户权限，超级用户有所有权限
        if ($this->isSuperAdmin()) {
            $this->userPermissions = $this->allPermission;
        } elseif ($this->isBackend()) {
            $this->userPermissionIds = Yii::$app->cacheSystem->getUserPermissionIds(Yii::$app->user->id);
            $this->userPermissions = ArrayHelper::sliceIds($this->allPermission, $this->userPermissionIds);
        }

        if (count($this->userPermissions)) {
            $this->userPermissionsTree = ArrayHelper::tree($this->userPermissions, 0, true);
            $this->userPermissionPaths = ArrayHelper::getColumn($this->userPermissions, 'path');
        }
    }

    public function verify($url, $userPermissionPaths = null)
    {
        // 超级用户有所有权限
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (!$userPermissionPaths) {
            $userPermissionPaths = $this->userPermissionPaths;
        }

        return AuthHelper::verify($url, $userPermissionPaths);
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (in_array(Yii::$app->user->identity->username, $this->superAdminUsernames)) {
            return true;
        }

        return false;
    }

    /**
     * 判断是否为管理员，管理员可以看所有store的数据
     * @return bool
     */
    public function isAdmin()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if ($this->isSuperAdmin()) {
            return true;
        }

        // 不使用role的type，使用id区段提升性能
        foreach (Yii::$app->user->identity->userRoles as $model) {
            if ($model->role_id <= $this->maxAdminRoleId) {
                return true;
            }
        }

        return false;
    }

    /**
     * 是否能进后台
     * @return bool
     */
    public function isBackend()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if ($this->isAdmin()) {
            return true;
        }

        foreach (Yii::$app->user->identity->userRoles as $model) {
            if ($model->role_id <= $this->maxStoreRoleId) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getSuperAdminRoleIdRange()
    {
        return [0, $this->maxSuperAdminRoleId];
    }

    /**
     * @return array
     */
    public function getAdminRoleIdRange()
    {
        return [$this->maxSuperAdminRoleId, $this->maxAdminRoleId];
    }

    /**
     * @return array
     */
    public function getStoreRoleIdRange()
    {
        return [$this->maxAdminRoleId, $this->maxStoreRoleId];
    }
}
