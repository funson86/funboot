<?php

namespace common\components\base;

use common\helpers\ArrayHelper;
use common\models\base\Dict;
use common\models\base\DictData;
use common\models\base\Lang;
use common\models\base\Permission;
use common\models\base\SettingType;
use common\models\cms\Catalog;
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
        $data = Yii::$app->cache->get('allStore');
        if (!$data) {
            $data = ArrayHelper::mapIdData(Store::find()->all());
            Yii::$app->cache->set('allStore', $data);
        }
        return $data;
    }

    /**
     * @return bool
     */
    public function clearAllStore()
    {
        return Yii::$app->cache->delete('allStore');
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function refreshStoreById($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();

        $data = Yii::$app->cache->get('allStore');
        if (!$data) {
            $data = Store::find()->all();
            Yii::$app->cache->set('allStore', $data);
            return true;
        }

        $model = Store::findOne($storeId);
        $data[$model->id] = $model;
        Yii::$app->cache->set('allStore', $data);
        return true;
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllPermission()
    {
        $data = Yii::$app->cache->get('allPermission');
        if (!$data) {
            $data = Permission::find()->where(['status' => Permission::STATUS_ACTIVE])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->asArray()->all();
            Yii::$app->cache->set('allPermission', $data);
        }
        return $data;
    }

    /**
     * @return bool
     */
    public function clearAllPermission()
    {
        Yii::$app->cache->delete('allPermission');
        $users = User::find()->select(['id'])->asArray()->all();
        foreach ($users as $user) {
            Yii::$app->cache->delete('userPermissionIds:' . $user['id']);
        }
        return true;
    }

    /**
     * @param $userId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getUserPermissionIds($userId)
    {
        $data = Yii::$app->cache->get('userPermissionIds:' . $userId);
        if (!$data) {
            $data = UserPermission::getUserPermissions(Yii::$app->user->id);
            Yii::$app->cache->set('userPermissionIds:' . $userId, $data);
        }

        return $data;
    }

    /**
     * @return bool
     */
    public function clearUserPermissionIds($userId)
    {
        return Yii::$app->cache->delete('userPermissionIds:' . $userId);
    }

    /**
     * @param $userId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getUserRoleIds($userId)
    {
        $data = Yii::$app->cache->get('userRoleIds:' . $userId);
        if (!$data) {
            $data = UserPermission::getUserPermissions(Yii::$app->user->id, true);
            Yii::$app->cache->set('userRoleIds:' . $userId, $data);
        }

        return $data;
    }

    /**
     * @return bool
     */
    public function clearUserRoleIds($userId)
    {
        return Yii::$app->cache->delete('userRoleIds:' . $userId);
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllDict()
    {
        $data = Yii::$app->cache->get('allDict');
        if (!$data) {
            $data = Dict::find()->with('dictDatas')->asArray()->all();
            Yii::$app->cache->set('allDict', $data);
        }
        return $data;
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
        $data = Yii::$app->cache->get('allDictData');
        if (!$data) {
            $data = DictData::find()->where(['status' => DictData::STATUS_ACTIVE])->asArray()->all();
            Yii::$app->cache->set('allDictData', $data);
        }
        return $data;
    }

    /**
     * @param $storeId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getStoreSetting($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        $data = Yii::$app->cache->get('storeSetting:' . $storeId);
        if (!$data) {
            $data = SettingType::find()->where(['status' => SettingType::STATUS_ACTIVE])
                ->with(['setting' => function ($query) use ($storeId) {
                    $query->andWhere(['store_id' => $storeId]);
                }])
                ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])
                ->asArray()
                ->all();
            Yii::$app->cache->set('storeSetting:' . $storeId, $data);
        }
        return $data;
    }

    /**
     * @return bool
     */
    public function clearAllSetting()
    {
        $stores = self::getAllStore();
        foreach ($stores as $store) {
            return Yii::$app->cache->delete('storeSetting:' . $store->id);
        }
    }

    /**
     * @param $storeId
     * @return bool
     */
    public function clearStoreSetting($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return Yii::$app->cache->delete('storeSetting:' . $storeId);
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

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    /*public function getAllLang()
    {
        // 数据量大有风险
        $data = Yii::$app->cache->get('allLang');
        if (!$data) {
            $data = Lang::find()->select(['name', 'target', 'table_code', 'target_id', 'content'])->all();

            foreach ($data as $item) {
                Yii::$app->cache->set('lang:' . $item->table_code . ':' . $item->target_id . ':' . $item->name . ':' . $item->target, $item->content);
            }

            Yii::$app->cache->set('allLang', $data);
        }
        return $data;
    }*/

    /**
     * @return bool
     */
    /*public function clearAllLang()
    {
        return Yii::$app->cache->delete('allLang');
    }*/

    /**
     * @param $tableCode
     * @param $targetId
     * @param $field
     * @param string $default
     * @param null $target
     * @param bool $force
     * @return mixed|string
     */
    public function getLang($tableCode, $targetId, $field, $default = '', $target = null, $force = false)
    {
        if ($force) {
            $this->refreshLang($tableCode, $targetId);
        }

        !$target && $target = Yii::$app->language;
        if (!Yii::$app->cache->get('lang:' . $tableCode . ':' . $targetId . ':' . $field . ':' . $target)) {
            $this->refreshLang($tableCode, $targetId);
        }

        return Yii::$app->cache->get('lang:' . $tableCode . ':' . $targetId . ':' . $field . ':' . $target) ?: $default;
    }

    public function refreshLang($tableCode, $targetId)
    {
        $data = Lang::find()->where(['table_code' => $tableCode, 'target_id' => $targetId])->all();
        foreach ($data as $item) {
            Yii::$app->cache->set('lang:' . $item->table_code . ':' . $item->target_id . ':' . $item->name . ':' . $item->target, $item->content);
        }

        return true;
    }

    public function refreshStoreLang($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        $data = Lang::find()->where(['store_id' => $storeId])->all();
        foreach ($data as $item) {
            Yii::$app->cache->set('lang:' . $item->table_code . ':' . $item->target_id . ':' . $item->name . ':' . $item->target, $item->content);
        }
    }

}
