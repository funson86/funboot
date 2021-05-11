<?php

namespace common\components\bbs;

use common\components\base\CacheSystem;
use common\helpers\ArrayHelper;
use common\models\bbs\Node;
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
    public function clearAllCategory()
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
        $data = false; //Yii::$app->cache->get('bbsStoreNode:' . $storeId);
        if (!$data) {
            $allNode = $this->getAllNode();
            $list = [];
            foreach ($allNode as $node) {
                if ($node->store_id == $storeId) {
                    if (is_null($parentId)) {
                        if ($all || (!$all && $node->status == Node::STATUS_ACTIVE)) {
                            $list[] = $isArray ? $node->attributes : $node;
                        }
                    } else {
                        if ($node->parent_id == $parentId) {
                            if ($all || (!$all && $node->status == Node::STATUS_ACTIVE)) {
                                $list[] = $isArray ? $node->attributes : $node;;
                            }
                        }
                    }
                }
            }

            $data = $list;
            // Yii::$app->cache->set('bbsStoreNode:' . $storeId, $data);
        }
        return $data;
    }

    /**
     * @return bool
     */
    public function clearStoreNode($storeId)
    {
        $this->clearAllStore();
        return Yii::$app->cache->delete('bbsStoreNode:' . $storeId);
    }

}
