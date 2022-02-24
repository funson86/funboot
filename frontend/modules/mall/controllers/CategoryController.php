<?php

namespace frontend\modules\mall\controllers;

use common\helpers\ArrayHelper;
use common\models\base\Lang;
use common\models\mall\Brand;
use common\models\mall\Category;
use common\models\mall\Product;
use common\models\base\SearchLog;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class CategoryController
 * @package frontend\modules\mall\controllers
 * @author funson86 <funson86@gmail.com>
 */
class CategoryController extends BaseController
{
    public function actionIndex()
    {
        return $this->goHome();
    }

    /**
     * 分类显示和搜索 共用，通过有参数keyword判定
     * @return string|\yii\web\Response
     */
    public function actionView()
    {
        $keyword = Yii::$app->request->get('keyword');
        if (!is_null($keyword)) {
            if (strlen($keyword) > 0) {
                $productIds = ArrayHelper::getColumn(Lang::find()->where(['store_id' => $this->getStoreId(), 'table_code' => Product::getTableCode()])->andWhere(['like', 'content', $keyword])->all(), 'target_id');

                SearchLog::create($keyword);
            } else {
                $productIds = ArrayHelper::getColumn(Yii::$app->cacheSystemMall->getProducts(), 'id');
            }
        } else {
            $id = Yii::$app->request->get('id');
            $seoUrl = Yii::$app->request->get('seo_url');
            if ($id) {
                $model = Category::findOne(['store_id' => $this->getStoreId(), 'id' => $id]);
            } elseif ($seoUrl) {
                $model = Category::findOne(['store_id' => $this->getStoreId(), 'seo_url' => $seoUrl]);
            }

            if (!$model) {
                return $this->goBack();
            }

            $allCategory = Yii::$app->cacheSystemMall->getCategories();
            $arrCategory = Category::getArraySubCatalogId($model->id, $allCategory);
        }

        // 非搜索情况下显示所有目录，支持所有商品链接
        if (!(!is_null($keyword) && strlen($keyword) > 0)) {
            $categories = Yii::$app->cacheSystemMall->getCategoriesArray();
            $categoriesTree = ArrayHelper::tree($categories);
        }

        $query = Product::find()->where(['store_id' => $this->getStoreId(), 'status' => Category::STATUS_ACTIVE]);
        isset($arrCategory) && $query->andWhere(['category_id' => $arrCategory]);
        isset($productIds) && $query->andWhere(['id' => $productIds]);
        $query->andFilterWhere(['brand_id' => Yii::$app->request->get('brand_id')]);
        if (Yii::$app->request->get('price')) {
            $arrPrice = explode(',', Yii::$app->request->get('price'));
            $query->andWhere(['between', 'price', ($arrPrice[0] ?? 0), ($arrPrice[1] ?? 100000)]);
        }

        // 侧栏筛选
        $query1 = clone $query;
        $priceMinMax = $query1->select('min(price) as min, max(price) as max')->asArray()->one();
        isset($arrPrice[0]) && $priceMinMax['min'] = $arrPrice[0];
        isset($arrPrice[1]) && $priceMinMax['max'] = $arrPrice[1];
        $query2 = clone $query;
        $brandIds = ArrayHelper::getColumn($query2->select('distinct(brand_id)')->all(), 'brand_id');
        $brandFilter = Brand::find()->where(['store_id' => $this->getStoreId(), 'status' => Brand::STATUS_ACTIVE, 'id' => $brandIds])->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => Yii::$app->request->get('page-size') ?? (Yii::$app->params['defaultPageSizeMallProduct'] ?? 1),
            ],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        $sort = $dataProvider->getSort();
        $sort->attributes['sales']['desc'] = ['sales' => SORT_DESC, 'id' => SORT_DESC];
        $sort->attributes['id']['asc'] = ['id' => SORT_ASC];
        $sort->attributes['id']['desc'] = ['id' => SORT_DESC];
        $sort->attributes['price']['asc'] = ['price' => SORT_ASC, 'id' => SORT_DESC];
        $sort->attributes['price']['desc'] = ['price' => SORT_DESC, 'id' => SORT_DESC];

        return $this->render($this->action->id, [
            'model' => $model ?? null,
            'categoriesTree' => $categoriesTree ?? null,
            'products' => $dataProvider->getModels(),
            'pagination' => $dataProvider->pagination,
            'priceMinMax' => $priceMinMax,
            'brandFilter' => $brandFilter,
        ]);
    }
}
