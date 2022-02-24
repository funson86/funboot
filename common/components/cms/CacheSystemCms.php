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
            $this->clearCatalogs($model->id);
            $this->clearPages($model->id);
        }
    }

    /**
     * @param $storeId
     * @param null $parentId
     * @param bool $all
     * @param bool $isArray
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getCatalogs($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        $data = Yii::$app->cache->get('cmsCatalog:' . $storeId);
        if (!$data) {
            $data = Catalog::find()->where(['store_id' => $storeId,])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set('cmsCatalog:' . $storeId, $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @return bool
     */
    public function clearCatalogs($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return Yii::$app->cache->delete('cmsCatalog:' . $storeId);
    }

    /**
     * @param null $storeId
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getPages($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();

        $data = Yii::$app->cache->get('cmsPage:' . $storeId);
        if (!$data) {
            $data = Page::find()->where(['store_id' => $storeId,])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
            Yii::$app->cache->set('cmsPage:' . $storeId, $data);
        }
        return ArrayHelper::mapIdData($data);
    }

    /**
     * @return bool
     */
    public function clearPages($storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return Yii::$app->cache->delete('cmsPage:' . $storeId);
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getPageById($id, $storeId = null)
    {
        $data = $this->getCatalogs($storeId);
        return $data[$id] ?? null;
    }

    /**
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getPageByCode($code, $storeId = null)
    {
        $data = ArrayHelper::mapIdData($this->getPages($storeId), 'code');
        return $data[$code] ?? null;
    }

}
