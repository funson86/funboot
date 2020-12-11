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

    public function getId()
    {
        return $this->store->id ?? Yii::$app->params['defaultStoreId'];
    }

    public function getUserId()
    {
        return $this->store->user_id ?? Yii::$app->params['defaultUserId'];
    }

}
