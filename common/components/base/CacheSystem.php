<?php

namespace common\components\base;

use common\models\base\Dict;
use common\models\base\DictData;
use common\models\base\Permission;
use common\models\base\SettingType;
use common\models\Store;
use common\models\User;
use common\services\base\UserPermission;
use Yii;

/**
 * Class CacheSystem
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class CacheSystem extends \yii\base\Component
{
    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllStore()
    {
        $allStore = Yii::$app->cache->get('allStore');
        if (!$allStore) {
            $allStore = Store::find()->all();
            Yii::$app->cache->set('allStore', $allStore);
        }
        return $allStore;
    }

    /**
     * @return bool
     */
    public function clearAllStore()
    {
        return Yii::$app->cache->delete('allStore');
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllPermission()
    {
        $allPermission = Yii::$app->cache->get('allPermission');
        if (!$allPermission) {
            $allPermission = Permission::find()->where(['status' => Permission::STATUS_ACTIVE])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->asArray()->all();
            Yii::$app->cache->set('allPermission', $allPermission);
        }
        return $allPermission;
    }

    /**
     * @return bool
     */
    public function clearAllPermission()
    {
        Yii::$app->cache->delete('allPermission');
        $users = User::find()->all();
        foreach ($users as $user) {
            Yii::$app->cache->delete('userPermissionIds:' . $user->id);
        }
        return true;
    }

    /**
     * @param $userId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getUserPermissionIds($userId)
    {
        $userPermissionIds = Yii::$app->cache->get('userPermissionIds:' . $userId);
        if (!$userPermissionIds) {
            $userPermissionIds = UserPermission::getUserPermissions(Yii::$app->user->id);
            Yii::$app->cache->set('userPermissionIds:' . $userId, $userPermissionIds);
        }

        return $userPermissionIds;
    }

    /**
     * @return bool
     */
    public function clearUserPermissionIds($userId)
    {
        return Yii::$app->cache->delete('userPermissionIds:' . $userId);
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllDict()
    {

        $allDict = Yii::$app->cache->get('allDict');
        if (!$allDict) {
            $allDict = Dict::find()->with('dictDatas')->asArray()->all();
            Yii::$app->cache->set('allDict', $allDict);
        }
        return $allDict;
    }

    /**
     * @return bool
     */
    public function clearAllDict()
    {
        return Yii::$app->cache->delete('allDict') && Yii::$app->cache->delete('allDictData');
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllDictData()
    {
        $allDictData = Yii::$app->cache->get('allDictData');
        if (!$allDictData) {
            $allDictData = DictData::find()->where(['status' => DictData::STATUS_ACTIVE])->asArray()->all();
            Yii::$app->cache->set('allDictData', $allDictData);
        }
        return $allDictData;
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllSetting()
    {
        $allSetting = Yii::$app->cache->get('allSetting');
        if (!$allSetting) {
            $stores = Store::find()->all();
            foreach ($stores as $store) {
                $settingTypes = SettingType::find()->where(['status' => SettingType::STATUS_ACTIVE])
                    ->with(['setting' => function ($query) use ($store) {
                        $query->andWhere(['store_id' => $store->id]);
                    }])
                    ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])
                    ->asArray()
                    ->all();
                $allSetting[$store->id] = $settingTypes;
            }

            Yii::$app->cache->set('allSetting', $allSetting);
        }
    }

    /**
     * @param $storeId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getStoreSetting($storeId)
    {
        $allSetting = Yii::$app->cache->get('allSetting');
        if (!isset($allSetting[$storeId])) {
            $settingTypes = SettingType::find()->where(['status' => SettingType::STATUS_ACTIVE])
                ->with(['setting' => function ($query) use ($storeId) {
                    $query->andWhere(['store_id' => $storeId]);
                }])
                ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])
                ->asArray()
                ->all();
        } else {
            $settingTypes = $allSetting[$storeId];
        }
        $allSetting[$storeId] = $settingTypes;
        Yii::$app->cache->set('allSetting', $allSetting);
        return $settingTypes;
    }

    /**
     * @return bool
     */
    public function clearAllSetting()
    {
        return Yii::$app->cache->delete('allSetting');
    }

    /**
     * @return bool
     */
    public function clearStoreSetting($storeId)
    {
        $allSetting = $this->getAllSetting();
        unset($allSetting[$storeId]);
        return Yii::$app->cache->set('allSetting', $allSetting);
    }

    public function setLanguage($lang, $userId = 0, $sessionId = null)
    {
        if ($userId > 0) {
            Yii::$app->cache->set('langU:' . $userId, $lang);
        } elseif ($sessionId) {
            Yii::$app->cache->set('langS:' . $sessionId, $lang);
        }
        return true;
    }

    public function getLanguage($userId = 0, $sessionId = null)
    {
        $lang = null;
        if ($userId > 0) {
            $lang = Yii::$app->cache->get('langU:' . $userId);
        } elseif ($sessionId) {
            $lang = Yii::$app->cache->get('langS:' . $sessionId);
        }
        return $lang;
    }

    public function clearLanguage($userId = 0, $sessionId = null)
    {
        return Yii::$app->cache->delete('langS:*');
    }
}
