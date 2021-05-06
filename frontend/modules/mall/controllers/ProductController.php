<?php

namespace frontend\modules\mall\controllers;

use common\models\mall\Attribute;
use common\models\mall\AttributeSet;
use common\models\mall\Comment;
use common\models\mall\Consultation;
use common\models\mall\Favorite;
use common\models\mall\Param;
use common\models\mall\ProductAttributeValueLabel;
use common\models\mall\ProductParam;
use common\models\mall\ProductSku;
use common\models\mall\SearchLog;
use common\models\mall\Brand;

use Yii;
use common\models\mall\Category;
use common\models\mall\Product;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use common\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ProductController extends BaseController
{
    const PRODUCT_SORT_CREATED_AT = 1;
    const PRODUCT_SORT_SALES = 2;

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $allCategory = Category::find()->asArray()->all();
        $arrayCategoryIdName = ArrayHelper::map($allCategory, 'id', 'name');
        $rootCategoryId = Category::getRootCatalogId($model->category_id, $allCategory);
        $arraySameRootCategory = Category::getArraySubCatalogId($rootCategoryId, $allCategory);

        // 同类商品  和 同大类商品
        $sameCategoryProducts = Product::find()->where(['category_id' => $model->category_id])->orderBy(['sales' => SORT_DESC])->limit(3)->all();
        $sameRootCategoryProducts = Product::find()->where(['category_id' => $arraySameRootCategory])->orderBy(['sales' => SORT_DESC])->limit(Yii::$app->params['productHotCount'])->all();

        // 记录浏览日志
        $historyProducts = [];
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('productHistory')) {
            $arrHistory = explode(',', $cookies->getValue('productHistory'));

            foreach ($arrHistory as $productId) {
                $product = Product::findOne($productId);
                if ($product) {
                    array_push($historyProducts, $product);
                }
            }

            array_unshift($arrHistory, $id);
            $arrHistory = array_unique($arrHistory);
            while (count($arrHistory) > Yii::$app->params['productHistoryCount']) {
                array_pop($arrHistory);
            }
            Yii::$app->response->cookies->remove('productHistory');
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'productHistory',
                'value' => implode(',', $arrHistory),
                'expire' => time() + 3600 * 24 * 30,
            ]));
        } else {
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'productHistory',
                'value' => $id,
                'expire' => time() + 3600 * 24 * 30,
            ]));
        }

        // 计算属性
        $enableValueIds = [];
        $productSkus = ProductSku::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id])->asArray()->all();
        if ($productSkus) {
            $enableValueIds = array_unique(explode(',', implode(',', ArrayHelper::getColumn($productSkus, 'attribute_value'))));
        }
        foreach ($productSkus as &$productSku) {
            $attributeValueIds = explode(',', $productSku['attribute_value']);
            $productSku['attribute_value'] = ArrayHelper::intValue($attributeValueIds, true);
        }

        $productAttributeValueLabels = ProductAttributeValueLabel::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $id])->all();
        $mapProductAttributeValueIdLabel = ArrayHelper::map($productAttributeValueLabels, 'id', 'label');
        $mapProductAttributeValueAttributeValueIdLabel = ArrayHelper::map($productAttributeValueLabels, 'attribute_value_id', 'label');

        $attributes = [];
        if ($model->attribute_set_id > 0) {
            $attributeSet = AttributeSet::findOne($model->attribute_set_id);
            if (count($attributeSet->attributeSetAttributes) > 0) {
                $attributes = Attribute::find()
                    ->where(['store_id' => $this->getStoreId(), 'id' => ArrayHelper::getColumn($attributeSet->attributeSetAttributes, 'attribute_id')])
                    ->orderBy(['sort' => SORT_ASC])
                    ->with(['attributeValues' => function ($query) use ($enableValueIds) {
                        $query->andWhere(['id' => $enableValueIds]);
                    }])
                    ->all();
                foreach ($attributes as &$attribute) {
                    foreach ($attribute->attributeValues as &$attributeValue) {
                        $attributeValue->label = $mapProductAttributeValueAttributeValueIdLabel[$attributeValue->id] ?? '';
                    }
                    unset($attributeValue);
                }
                unset($attribute);
            }
        }

        // 计算参数
        $allParams = [];
        $mapProductParamIdContent = $arrProductParamIds = [];
        if ($model->param_id > 0) {
            $allParams = ArrayHelper::mapIdData(Param::find()->where(['store_id' => $this->getStoreId(), 'parent_id' => $product->param_id, 'status' => Param::STATUS_ACTIVE])->with('children')->all());
            $productParams = ProductParam::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $id])->all();
            $mapProductParamIdContent = ArrayHelper::map($productParams, 'param_id', 'content');
            $arrProductParamIds = ArrayHelper::getColumn($productParams, 'param_id');
        }

        return $this->render('view', [
            'model' => $model,
            'allCategory' => $allCategory,
            'arrayCategoryIdName' => $arrayCategoryIdName,
            'sameCategoryProducts' => $sameCategoryProducts,
            'sameRootCategoryProducts' => $sameRootCategoryProducts,
            'historyProducts' => $historyProducts,
            'attributes' => $attributes,
            'productSkus' => $productSkus,
            'allParams' => $allParams,
            'mapProductParamIdContent' => $mapProductParamIdContent,
            'arrProductParamIds' => $arrProductParamIds,
        ]);
    }
    
    public function actionBrand()
    {
    	$allBrands = Brand::find()->where(['status' => Brand::STATUS_ACTIVE])->andwhere(['<>', 'logo', ''])->all();
    	 
        return $this->render('allbrands', [
            'allBrands' => $allBrands,
        ]);    	
    } 

    public function actionSearch($keyword = null, $type = self::PRODUCT_SORT_CREATED_AT)
    {
        if ($type == self::PRODUCT_SORT_CREATED_AT) {
            $type = 'created_at';
        } elseif ($type == self::PRODUCT_SORT_SALES) {
            $type = 'sales';
        } else {
            throw new BadRequestHttpException('Type is not supported.');
        }

        if (trim($keyword)) {
            $keyword = trim($keyword);
            $searchLog = new SearchLog([
                'session_id' => Yii::$app->session->id,
                'user_id' => Yii::$app->user->id,
                'keyword' => $keyword,
                'ip' => Yii::$app->request->userIP,
            ]);
            $searchLog->save();

            $query = Product::find()->where('name like "%' . $keyword . '%"');
        } else {
            $query = Product::find();
        }
        $query->orderBy(['sales' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => Yii::$app->params['defaultPageSizeProduct']],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        return $this->render('search', [
            'products' => $dataProvider->getModels(),
            'pagination' => $dataProvider->pagination,
        ]);

    }

    public function actionFavorite($id)
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $favorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'product_id' => $id])->one();
            if (!$favorite) {
                $model = new Favorite([
                    'user_id' => Yii::$app->user->id,
                    'product_id' => $id,
                ]);

                if ($model->save()) {
                    return [
                        'status' => 1,
                    ];
                }
            }
            return [
                'status' => 2,
            ];
        } else {
            return $this->redirect('site/login');
        }
    }

    public function actionComment($productId)
    {
        $this->layout = false;
        if (Yii::$app->request->isAjax && $productId) {
            $query = Comment::find()->where(['product_id' => $productId, 'status' => Status::STATUS_ACTIVE]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => ['defaultPageSize' => Yii::$app->params['defaultPageSizeProduct']],
                'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            ]);

            return $this->render('comment', [
                'data' => $dataProvider->getModels(),
                'pagination' => $dataProvider->pagination,
            ]);
        }
    }

    public function actionConsultation($productId)
    {
        $this->layout = false;
        if (Yii::$app->request->isAjax && $productId) {
            $query = Consultation::find()->where(['product_id' => $productId, 'status' => Status::STATUS_ACTIVE]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => ['defaultPageSize' => Yii::$app->params['defaultPageSizeProduct']],
                'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            ]);

            return $this->render('consultation', [
                'data' => $dataProvider->getModels(),
                'pagination' => $dataProvider->pagination,
            ]);
        }
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $action = false)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
