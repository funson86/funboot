<?php

namespace common\components\base;

use common\helpers\ArrayHelper;
use common\helpers\AuthHelper;
use common\models\base\Permission;
use common\models\base\RolePermission;
use common\models\base\SettingType;
use common\models\base\UserRole;
use common\models\Store;
use common\models\User;
use common\services\base\UserPermission;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class StoreSystem
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class StoreSystem extends \yii\base\Component
{
    public $store;

    public function set($store)
    {
        $this->store = $store;
    }

    public function get()
    {
        return $this->store;
    }

    public function getById($storeId = null)
    {
        if (!$storeId) {
            return $this->store;
        }

        $data = ArrayHelper::mapIdData(Yii::$app->cacheSystem->getAllStore());

        return $data[$storeId] ?? $this->store;
    }


    public function getId()
    {
        return $this->store->id ?? Yii::$app->params['defaultStoreId'];
    }

    public function getUserId()
    {
        return $this->store->user_id ?? Yii::$app->params['defaultUserId'];
    }

    public function getRouteCode()
    {
        $data = Yii::$app->params['routeCode'];

        return $data[$this->store->route] ?? 1;
    }

}
