<?php

namespace common\components\bbs;

use common\components\base\CacheSystem;
use common\helpers\ArrayHelper;
use common\models\bbs\Node;
use common\models\bbs\Tag;
use common\models\mall\Category;
use Yii;

/**
 * Class CacheSystemBbs
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class CacheSystemBbs extends CacheSystem
{
    const BBS_ALL_NODE = 'BBS_ALL_NODE';
    const BBS_STORE_NODE = 'bbsStoreNode:';
    const BBS_ALL_TAG = 'bbsAllTag';

    /**
     * clear all data, if specify storeId, then only clear one store data.
     * @param null $storeId
     * @return bool
     */
    public function clearBbsAllData($storeId = null)
    {
        if ($storeId) {
            return $this->clearItems($storeId);
        } else {
            $models = Yii::$app->cacheSystem->getAllStore();
            foreach ($models as $model) {
                $this->clearItems($model->id);
            }
        }
        return true;
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllNode()
    {
        $data = Yii::$app->cache->get(self::BBS_ALL_NODE);
        if (!$data) {
            $data = Node::find()->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set(self::BBS_ALL_NODE, $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @return bool
     */
    public function clearAllNode()
    {
        return Yii::$app->cache->delete(self::BBS_ALL_NODE);
    }

    /**
     * @param $storeId
     * @param null $parentId
     * @param bool $all
     * @param bool $isArray
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getStoreNode($storeId = null, $parentId = null, $all = false, $isArray = false)
    {
        $storeId = is_null($storeId) ? Yii::$app->storeSystem->getId() : $storeId;

        $models = $this->getAllNode();
        $list = [];
        foreach ($models as $model) {
            if ($model->store_id == $storeId) {
                if (is_null($parentId)) {
                    if ($all || (!$all && $model->status == Node::STATUS_ACTIVE)) {
                        $list[] = $isArray ? $model->attributes : $model;
                    }
                } else {
                    if ($model->parent_id == $parentId) {
                        if ($all || (!$all && $model->status == Node::STATUS_ACTIVE)) {
                            $list[] = $isArray ? $model->attributes : $model;
                        }
                    }
                }
            }
        }

        return $list;
    }

    /**
     * @return bool
     */
    public function clearStoreNode($storeId)
    {
        return Yii::$app->cache->delete(self::BBS_STORE_NODE . $storeId);
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllTag()
    {
        $data = Yii::$app->cache->get(self::BBS_ALL_TAG);
        if (!$data) {
            $data = Tag::find()->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set(self::BBS_ALL_TAG, $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @return bool
     */
    public function clearAllTag()
    {
        return Yii::$app->cache->delete(self::BBS_ALL_TAG);
    }


    /**
     * @param $storeId
     * @param null $parentId
     * @param bool $all
     * @param bool $isArray
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getStoreTag($storeId = null, $parentId = null, $all = false, $isArray = false)
    {
        $storeId = is_null($storeId) ? Yii::$app->storeSystem->getId() : $storeId;

        $models = $this->getAllTag();
        $list = [];
        foreach ($models as $model) {
            if ($model->store_id == $storeId) {
                if (is_null($parentId)) {
                    if ($all || (!$all && $model->status == Tag::STATUS_ACTIVE)) {
                        $list[] = $isArray ? $model->attributes : $model;
                    }
                } else {
                    if ($model->parent_id == $parentId) {
                        if ($all || (!$all && $model->status == Tag::STATUS_ACTIVE)) {
                            $list[] = $isArray ? $model->attributes : $model;
                        }
                    }
                }
            }
        }

        return $list;
    }
}
