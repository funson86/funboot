<?php

namespace common\components\mall;

use common\components\base\CacheSystem;
use common\helpers\ArrayHelper;
use common\models\mall\Attribute;
use common\models\mall\AttributeItem;
use common\models\mall\Category;
use common\models\mall\Product;
use common\models\mall\ProductSku;
use Yii;

/**
 * Class CacheSystemMall
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class CacheSystemMall extends CacheSystem
{
    /**
     * clear all data, if specify storeId, then only clear one store data.
     * @param null $storeId
     * @return bool
     */
    public function clearMallAllData($storeId = null)
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

    protected function clearItems($storeId = null)
    {
        $this->clearProductSkus($storeId);
        $this->clearAttribute($storeId);
        $this->clearAttributeItem($storeId);
        $this->clearCategories($storeId);
        $this->clearProducts($storeId);

        return true;
    }

    /**
     * @param $storeId
     * @param null $parentId
     * @param bool $all
     * @param bool $isArray
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getCategories($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        $data = Yii::$app->cache->get('mallCategory:' . $storeId);
        if (!$data) {
            $data = Category::find()->where(['store_id' => $storeId, 'status' => Category::STATUS_ACTIVE])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set('mallCategory:' . $storeId, $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getCategoryById($id, $storeId = null)
    {
        $data = $this->getCategories($storeId);
        return $data[$id] ?? null;
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function clearCategories($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return Yii::$app->cache->delete('mallCategory:' . $storeId);
    }

    /**
     * @param $storeId
     * @param null $parentId
     * @param bool $all
     * @param bool $isArray
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getCategoriesArray($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        $data = Yii::$app->cache->get('mallCategoryArray:' . $storeId);
        if (!$data) {
            $data = Category::find()->where(['store_id' => $storeId, 'status' => Category::STATUS_ACTIVE])->asArray()->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set('mallCategoryArray:' . $storeId, $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function clearCategoriesArray($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return Yii::$app->cache->delete('mallCategoryArray:' . $storeId);
    }

    /**
     * @param null $storeId
     * @param bool $force
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getProducts($storeId = null, $force = false)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();

        $data = Yii::$app->cache->get('mallProducts:' . $storeId);
        if (!$data || $force) {
            $data = Product::find()->where(['store_id' => $storeId, 'status' => Category::STATUS_ACTIVE])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set('mallProducts:' . $storeId, $data);

            foreach ($data as $model) {
                Yii::$app->cache->set('mallProduct:' . $model->id, $model);
            }
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function clearProducts($storeId = null)
    {
        $models = $this->getProducts($storeId);
        foreach ($models as $model) {
            Yii::$app->cache->delete('mallProduct:' . $model->id);
        }

        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return Yii::$app->cache->delete('mallProducts:' . $storeId);
    }

    /**
     * @param $id
     * @param null $storeId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getProductById($id, $storeId = null)
    {
        if (!Yii::$app->cache->get('mallProduct:' . $id)) {
            $data = Product::findOne($id);
            if (!$data) {
                return null;
            }

            Yii::$app->cache->set('mallProduct:' . $id, $data);
        }

        return Yii::$app->cache->get('mallProduct:' . $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteProductById($id, $storeId = null)
    {
        return Yii::$app->cache->delete('mallProduct:' . $id);
    }

    /**
     * @param $productId
     * @param null $storeId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getProductSkusByProductId($productId, $storeId = null)
    {
        if (!Yii::$app->cache->get('mallProductSkus:' . $productId)) {
            $data = ProductSku::find()->where(['product_id' => $productId])->all();
            if (!$data) {
                return null;
            }

            Yii::$app->cache->set('mallProductSkus:' . $productId, $data);
        }

        return Yii::$app->cache->get('mallProductSkus:' . $productId);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteProductSkusByProductId($productId, $storeId = null)
    {
        return Yii::$app->cache->delete('mallProductSkus:' . $productId);
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function clearProductSkus($storeId = null)
    {
        $models = $this->getProducts($storeId);
        foreach ($models as $model) {
            Yii::$app->cache->delete('mallProductSkus:' . $model->id);
        }
        return true;
    }

    /**
     * @param $productId
     * @param null $storeId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getProductSkuByProductId($productId, $attributeValue, $storeId = null)
    {
        $data = $this->getProductSkusByProductId($productId);
        if ($data) {
            foreach ($data as $model) {
                if ($model->attribute_value == $attributeValue) {
                    return $model;
                }
            }
        }

        return null;
    }

    /**
     * @param $id
     * @param null $storeId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAttributeById($id, $storeId = null)
    {
        if (!Yii::$app->cache->get('mallAttribute:' . $id)) {
            $data = Attribute::findOne($id);
            if (!$data) {
                return null;
            }

            Yii::$app->cache->set('mallAttribute:' . $id, $data);
        }

        return Yii::$app->cache->get('mallAttribute:' . $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteAttributeById($id, $storeId = null)
    {
        return Yii::$app->cache->delete('mallAttribute:' . $id);
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function clearAttribute($storeId = null)
    {
        $models = $this->getProducts($storeId);
        foreach ($models as $model) {
            Yii::$app->cache->delete('mallAttribute:' . $model->id);
        }
        return true;
    }

    /**
     * @param $id
     * @param null $storeId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getAttributeItemById($id, $storeId = null)
    {
        if (!Yii::$app->cache->get('mallAttributeItem:' . $id)) {
            $data = AttributeItem::findOne($id);
            if (!$data) {
                return null;
            }

            Yii::$app->cache->set('mallAttributeItem:' . $id, $data);
        }

        return Yii::$app->cache->get('mallAttributeItem:' . $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteAttributeItemById($id, $storeId = null)
    {
        return Yii::$app->cache->delete('mallAttributeItem:' . $id);
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function clearAttributeItem($storeId = null)
    {
        $models = $this->getProducts($storeId);
        foreach ($models as $model) {
            Yii::$app->cache->delete('mallAttributeItem:' . $model->id);
        }
        return true;
    }

}
