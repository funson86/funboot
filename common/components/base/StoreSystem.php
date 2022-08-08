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

    /**
     * @param $store
     * @return mixed
     */
    public function set($store)
    {
        return $this->store = $store ?? Store::findOne(Yii::$app->params['defaultStoreId'] ?? 2);
    }

    /**
     * @return Store
     */
    public function get()
    {
        return $this->store;
    }

    /**
     * @param null $storeId
     * @return Store
     */
    public function getById($storeId = null)
    {
        if (!$storeId) {
            return $this->store;
        }

        $data = Yii::$app->cacheSystem->getAllStore();

        return $data[$storeId] ?? $this->store;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->store->id ?? Yii::$app->params['defaultStoreId'];
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->store->user_id ?? Yii::$app->params['defaultUserId'];
    }

    /**
     * @return int|mixed
     */
    public function getRouteCode()
    {
        $data = Yii::$app->params['routeCode'];

        return $data[$this->store->route] ?? 1;
    }

}
