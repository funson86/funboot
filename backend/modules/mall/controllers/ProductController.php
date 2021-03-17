<?php

namespace backend\modules\mall\controllers;

use common\helpers\ArrayHelper;
use common\models\mall\Attribute;
use common\models\mall\AttributeSet;
use common\models\mall\AttributeValue;
use common\models\mall\ProductSku;
use Yii;
use common\models\mall\Product;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;

/**
 * Product
 *
 * Class ProductController
 * @package backend\modules\mall\controllers
 */
class ProductController extends BaseController
{
    /**
      * @var Product
      */
    public $modelClass = Product::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name'];

    /**
     * 可编辑字段
     *
     * @var int
     */
    protected $editAjaxFields = ['name', 'sort'];

    /**
     * 导入导出字段
     *
     * @var int
     */
    protected $exportFields = [
        'id' => 'text',
        'name' => 'text',
        'type' => 'select',
    ];

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id', null);
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $post = Yii::$app->request->post();

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$model->save()) {
                        var_dump($model->errors);die();
                        Yii::$app->logSystem->db($model->errors);
                        throw new NotFoundHttpException($this->getError($model));
                    }

                    if ($model->attribute_set_id > 0 && isset($post['skus'])) {
                        $skus = $post['skus'];

                        ProductSku::updateAll(['status' => ProductSku::STATUS_DELETED], ['store_id' => $this->getStoreId(), 'product_id' => $model->id]);

                        foreach ($skus as $attributeValue => $item) {
                            $productSku = ProductSku::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id, 'attribute_value' => $attributeValue])->one();
                            !$productSku && $productSku = new ProductSku();
                            $productSku->store_id = $this->getStoreId();
                            $productSku->attribute_value = $attributeValue;
                            $productSku->product_id = $model->id;
                            $productSku->sku = $item['sku'];
                            $productSku->thumb = $item['thumb'];
                            $productSku->price = $item['price'];
                            $productSku->market_price = $item['market_price'];
                            $productSku->cost_price = $item['cost_price'];
                            $productSku->wholesale_price = $item['wholesale_price'];
                            $productSku->stock = $item['stock'];
                            $productSku->status = $item['status'];

                            if (!$productSku->save()) {
                                Yii::$app->logSystem->db($model->errors);die();
                                throw new NotFoundHttpException($this->getError($model));
                            }
                        }

                        ProductSku::deleteAll(['status' => ProductSku::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    }

                    $transaction->commit();
                    return $this->redirectSuccess(['index']);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return $this->goBack();
                }

            }
        }

        $model->isAttribute = $model->attribute_set_id > 0 ? 1 : 0;
        $attributes = [];
        if ($model->isAttribute > 0) {
            $attributeSet = AttributeSet::findOne($model->attribute_set_id);
            if (count($attributeSet->attribute_ids) > 0) {
                $attributes = Attribute::find()
                    ->where(['store_id' => $this->getStoreId(), 'id' => $attributeSet->attribute_ids])->orderBy(['sort' => SORT_ASC])
                    ->with('attributeValues')
                    ->all();
            }
        }
        $mapAttributeIdName = ArrayHelper::map($attributes, 'id', 'name');

        // 计算已经使用的属性项
        $enableValueIds = [];
        $productSkus = ProductSku::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id])->asArray()->all();
        if ($productSkus) {
            $enableValueIds = array_unique(explode(',', implode(',', ArrayHelper::getColumn($productSkus, 'attribute_value'))));
        }
        $enableValues = [];
        $attributeValues = AttributeValue::find()->where(['store_id' => $this->getStoreId(), 'id' => $enableValueIds])->all();
        foreach ($attributeValues as $attributeValue) {
            $item = $attributeValue->attributes;
            $item['attribute_name'] = $mapAttributeIdName[$attributeValue->attribute_id] ?? '';

            $enableValues[] = $item;
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'attributes' => $attributes,
            'enableValues' => $enableValues,
            'productSkus' => $productSkus,
        ]);
    }
}
