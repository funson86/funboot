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
     * AuthSystem constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

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
        $data = [
            Store::ROUTE_SITE => SettingType::SUPPORT_SYSTEM_SITE,
            Store::ROUTE_PAY => SettingType::SUPPORT_SYSTEM_PAY,
            Store::ROUTE_CMS => SettingType::SUPPORT_SYSTEM_CMS,
            Store::ROUTE_BBS => SettingType::SUPPORT_SYSTEM_BBS,
            Store::ROUTE_MALL => SettingType::SUPPORT_SYSTEM_MALL,
            Store::ROUTE_WECHAT => SettingType::SUPPORT_SYSTEM_WECHAT,
        ];

        return $data[$this->store->route] ?? SettingType::SUPPORT_SYSTEM_SITE;
    }

}
