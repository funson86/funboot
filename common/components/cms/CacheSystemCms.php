<?php

namespace common\components\cms;

use common\components\base\CacheSystem;
use common\helpers\ArrayHelper;
use common\models\cms\Catalog;
use common\models\cms\Page;
use Yii;

/**
 * Class CacheSystemCms
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class CacheSystemCms extends CacheSystem
{
    /**
     * @return bool
     */
    public function clearCmsAllData()
    {
        $models = Yii::$app->cacheSystem->getAllStore();
        foreach ($models as $model) {
            $this->clearStoreCatalogs($model->id);
            $this->clearStorePages($model->id);
        }
    }

    /**
     * @param $storeId
     * @param null $parentId
     * @param bool $all
     * @param bool $isArray
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getStoreCatalogs($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        $data = Yii::$app->cache->get('cmsStoreCatalog:' . $storeId);
        if (!$data) {
            $data = Catalog::find()->where(['store_id' => $storeId,])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set('cmsStoreCatalog:' . $storeId, $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @return bool
     */
    public function clearStoreCatalogs($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return Yii::$app->cache->delete('cmsStoreCatalog:' . $storeId);
    }

    /**
     * @param null $storeId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getStorePages($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();

        $data = Yii::$app->cache->get('cmsStorePage:' . $storeId);
        if (!$data) {
            $data = Page::find()->where(['store_id' => $storeId,])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set('cmsStorePage:' . $storeId, $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @return bool
     */
    public function clearStorePages($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return Yii::$app->cache->delete('cmsStorePage:' . $storeId);
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getStorePageById($id, $storeId = null)
    {
        $data = $this->getStorePages($storeId);
        return $data[$id] ?? null;
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getStorePageByCode($code, $storeId = null)
    {
        $data = ArrayHelper::mapIdData($this->getStorePages($storeId), 'code');
        return $data[$code] ?? null;
    }

}
