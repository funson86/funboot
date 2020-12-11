<?php
namespace common\services\base;

use common\helpers\ArrayHelper;
use common\models\base\Permission;
use common\models\base\UserRole;
use common\models\User;
use common\services\BaseService;
use Yii;

/**
 * Class UserPermission
 * @author funson86 <funson86@gmail.com>
 */
class UserPermission extends BaseService
{
    public static function getUserPermissions($userId, $force = false)
    {
        if ($userId < 0) {
            return null;
        }

        $user = User::findOne($userId);
        if (!$user) {
            return null;
        }

        $permissions = UserRole::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with(['permission'])
            ->asArray()
            ->all();

        if (isset($permissions[0]['permission'])) {
            $permissionIds = ArrayHelper::getColumn($permissions[0]['permission'], 'permission_id');
            Yii::$app->cache->set('user_permissions:' . $userId, $permissionIds);
            return $permissionIds;
        }
    }
}