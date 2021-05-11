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
    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllNode()
    {
        $data = Yii::$app->cache->get('bbsAllNode');
        if (!$data) {
            $data = Node::find()->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set('bbsAllNode', $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @return bool
     */
    public function clearAllNode()
    {
        return Yii::$app->cache->delete('bbsAllNode');
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
        $this->clearAllStore();
        return Yii::$app->cache->delete('bbsStoreNode:' . $storeId);
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAllTag()
    {
        $data = Yii::$app->cache->get('bbsAllTag');
        if (!$data) {
            $data = Tag::find()->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set('bbsAllTag', $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @return bool
     */
    public function clearAllTag()
    {
        return Yii::$app->cache->delete('bbsAllTag');
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
