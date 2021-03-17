<?php

namespace backend\modules\mall\controllers;

use common\helpers\ArrayHelper;
use common\models\mall\Attribute;
use common\models\mall\AttributeSet;
use common\models\mall\AttributeValue;
use common\models\mall\ProductAttribute;
use common\models\mall\ProductAttributeValueLabel;
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

                $model->type = ArrayHelper::arrayToInt($post['Product']['types']);

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$model->save()) {
                        Yii::$app->logSystem->db($model->errors);
                        throw new NotFoundHttpException($this->getError($model));
                    }

                    // 计算多属性和sku
                    if ($model->attribute_set_id > 0 && isset($post['skus'])) {
                        $skus = $post['skus'];

                        ProductSku::updateAll(['status' => ProductSku::STATUS_DELETED], ['store_id' => $this->getStoreId(), 'product_id' => $model->id]);

                        foreach ($skus as $attributeValue => $item) {
                            $modelTemp = ProductSku::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id, 'attribute_value' => $attributeValue])->one();
                            !$modelTemp && $modelTemp = new ProductSku();
                            $modelTemp->store_id = $this->getStoreId();
                            $modelTemp->attribute_value = $attributeValue;
                            $modelTemp->product_id = $model->id;
                            $modelTemp->sku = $item['sku'];
                            $modelTemp->thumb = $item['thumb'];
                            $modelTemp->price = $item['price'];
                            $modelTemp->market_price = $item['market_price'];
                            $modelTemp->cost_price = $item['cost_price'];
                            $modelTemp->wholesale_price = $item['wholesale_price'];
                            $modelTemp->stock = $item['stock'];
                            $modelTemp->status = $item['status'];

                            if (!$modelTemp->save()) {
                                Yii::$app->logSystem->db($modelTemp->errors);
                                throw new NotFoundHttpException($this->getError($modelTemp));
                            }
                        }

                        ProductSku::deleteAll(['status' => ProductSku::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    } else { // 否则删除所有多属性数据
                        ProductSku::deleteAll(['store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    }

                    // 计算多属性标签
                    if ($model->attribute_set_id > 0 && isset($post['productAttributeValueLabels'])) {
                        $attributeValues = AttributeValue::find()->where(['store_id' => $this->getStoreId()])->all();
                        $mapAttributeValueIdName = ArrayHelper::map($attributeValues, 'id', 'name');
                        $mapAttributeValueIdTye = [];
                        foreach ($attributeValues as $item) {
                            $mapAttributeValueIdTye[$item->id] = $item->attribute0->type;
                        }

                        $productAttributeValueLabels = $post['productAttributeValueLabels'];

                        ProductAttributeValueLabel::updateAll(['status' => ProductSku::STATUS_DELETED], ['store_id' => $this->getStoreId(), 'product_id' => $model->id]);

                        foreach ($productAttributeValueLabels as $attributeValueId => $label) {
                            $modelTemp = ProductAttributeValueLabel::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id, 'attribute_value_id' => $attributeValueId])->one();
                            !$modelTemp && $modelTemp = new ProductAttributeValueLabel();
                            $modelTemp->store_id = $this->getStoreId();
                            $modelTemp->product_id = $model->id;
                            $modelTemp->attribute_value_id = $attributeValueId;
                            $modelTemp->name = $mapAttributeValueIdName[$attributeValueId] ?? '-';
                            $modelTemp->type = $mapAttributeValueIdTye[$attributeValueId] ?? Attribute::TYPE_TEXT;
                            $modelTemp->label = $modelTemp->type == Attribute::TYPE_COLOR ? str_replace('#', '', $label) : $label;
                            $modelTemp->status = ProductAttributeValueLabel::STATUS_ACTIVE;

                            if (!$modelTemp->save()) {
                                Yii::$app->logSystem->db($modelTemp->errors);
                                throw new NotFoundHttpException($this->getError($modelTemp));
                            }
                        }

                        ProductAttributeValueLabel::deleteAll(['status' => ProductSku::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    } else { // 否则删除所有多属性数据
                        ProductAttributeValueLabel::deleteAll(['store_id' => $this->getStoreId(), 'product_id' => $model->id]);
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
        $attributes = $attributeValues = [];

        $mapAttributeIdName = ArrayHelper::map($attributes, 'id', 'name');
        $mapProductAttributeValueIdLabel = [];
        if ($id > 0) {
            $productAttributeValueLabels = ProductAttributeValueLabel::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $id])->all();
            $mapProductAttributeValueIdLabel = ArrayHelper::map($productAttributeValueLabels, 'id', 'label');
            $mapProductAttributeValueAttributeValueIdLabel = ArrayHelper::map($productAttributeValueLabels, 'attribute_value_id', 'label');
        }

        if ($model->isAttribute > 0) {
            $attributeSet = AttributeSet::findOne($model->attribute_set_id);
            if (count($attributeSet->attribute_ids) > 0) {
                $attributes = Attribute::find()
                    ->where(['store_id' => $this->getStoreId(), 'id' => $attributeSet->attribute_ids])->orderBy(['sort' => SORT_ASC])
                    ->with('attributeValues')
                    ->all();

                if ($id > 0) {
                    foreach ($attributes as &$attribute) {
                        foreach ($attribute->attributeValues as &$attributeValue) {
                            $attributeValue->label = $mapProductAttributeValueAttributeValueIdLabel[$attributeValue->id] ?? '';
                        }
                    }
                }
            }
        }

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
            $item['label'] = $mapProductAttributeValueIdLabel[$attributeValue->id] ?? '';

            $enableValues[] = $item;
        }

        $model->types = ArrayHelper::intToArray($model->type, $this->modelClass::getTypeLabels());
        return $this->render($this->action->id, [
            'model' => $model,
            'attributes' => $attributes,
            'enableValues' => $enableValues,
            'productSkus' => $productSkus,
        ]);
    }
}
