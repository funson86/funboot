<?php

namespace backend\modules\mall\controllers;

use common\helpers\ArrayHelper;
use common\models\mall\Attribute;
use common\models\mall\AttributeSet;
use common\models\mall\AttributeItem;
use common\models\mall\Param;
use common\models\mall\ProductAttributeItemLabel;
use common\models\mall\ProductParam;
use common\models\mall\ProductSku;
use common\models\mall\ProductTag;
use common\models\mall\Tag;
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
     * @var bool
     */
    public $isMultiLang = true;
    public $isAutoTranslation = true;

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
        $this->beforeEdit($id, $model);
        $lang = $this->isMultiLang ? $this->beforeLang($id, $model) : [];

        $allParams = ArrayHelper::mapIdData(Param::find()->where(['store_id' => $this->getStoreId(), 'status' => Tag::STATUS_ACTIVE])->all());
        $mapAllParamIdName = ArrayHelper::map($allParams, 'id', 'name');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->translating = Yii::$app->request->post($model->formName())['translating'] ?? 0;

                $post = Yii::$app->request->post();

                $model->type = ArrayHelper::arrayToInt($post['Product']['types'] ?? []);

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$model->save()) {
                        Yii::$app->logSystem->db($model->errors);
                        throw new NotFoundHttpException($this->getError($model));
                    }
                    $this->afterEdit($id, $model);
                    $this->isMultiLang && $this->afterLang($id, $model);

                    // 标签
                    $tags = $post['Product']['tags'];
                    ProductTag::updateAll(['status' => ProductSku::STATUS_DELETED], ['store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    if (is_array($tags)) {
                        foreach ($tags as $tagId) {
                            $modelTemp = ProductTag::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id, 'tag_id' => $tagId])->one();
                            !$modelTemp && $modelTemp = new ProductTag();
                            $modelTemp->product_id = $model->id;
                            $modelTemp->tag_id = $tagId;
                            $modelTemp->status = Tag::STATUS_ACTIVE;
                            if (!$modelTemp->save()) {
                                Yii::$app->logSystem->db($modelTemp->errors);
                                throw new NotFoundHttpException($this->getError($modelTemp));
                            }
                        }
                    }
                    ProductTag::deleteAll(['status' => ProductSku::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'product_id' => $model->id]);

                    // 计算多属性和sku
                    if ($model->attribute_set_id > 0 && isset($post['skus'])) {
                        $skus = $post['skus'];
                        $minPrice = 0;

                        ProductSku::updateAll(['status' => ProductSku::STATUS_DELETED], ['store_id' => $this->getStoreId(), 'product_id' => $model->id]);

                        foreach ($skus as $attributeValue => $item) {
                            $modelTemp = ProductSku::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id, 'attribute_value' => $attributeValue])->one();
                            !$modelTemp && $modelTemp = new ProductSku();
                            // 按照id顺序用逗号分隔存储
                            $arrAttributeItem = explode(',', $attributeValue);
                            $modelTemp->attribute_value = implode(',', ArrayHelper::intValue($arrAttributeItem, true));
                            $modelTemp->product_id = $model->id;
                            $modelTemp->sku = $item['sku'];
                            $modelTemp->thumb = $item['thumb'];
                            $modelTemp->price = $item['price'];
                            $modelTemp->market_price = $item['market_price'];
                            $modelTemp->cost_price = $item['cost_price'];
                            $modelTemp->wholesale_price = $item['wholesale_price'];
                            $modelTemp->stock = $item['stock'];
                            $modelTemp->status = $item['status'];

                            $minPrice == 0 && $minPrice = $modelTemp->price;
                            ($modelTemp->price > 0) && (($minPrice > $modelTemp->price) && ($minPrice = $modelTemp->price));

                            if (!$modelTemp->save()) {
                                Yii::$app->logSystem->db($modelTemp->errors);
                                throw new NotFoundHttpException($this->getError($modelTemp));
                            }
                        }

                        ProductSku::deleteAll(['status' => ProductSku::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'product_id' => $model->id]);

                        // 多属性价格用大于0的最低价
                        $model->price = $minPrice;
                        if (!$model->save()) {
                            Yii::$app->logSystem->db($model->errors);
                        }
                    } else { // 否则删除所有多属性数据
                        ProductSku::deleteAll(['store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    }

                    // 计算多属性标签
                    if ($model->attribute_set_id > 0 && isset($post['productAttributeItemLabels'])) {
                        $attributeItems = AttributeItem::find()->where(['store_id' => $this->getStoreId()])->all();
                        $mapAttributeItemIdName = ArrayHelper::map($attributeItems, 'id', 'name');
                        $mapAttributeItemIdTye = [];
                        foreach ($attributeItems as $item) {
                            $mapAttributeItemIdTye[$item->id] = $item->attribute0->type;
                        }

                        $productAttributeItemLabels = $post['productAttributeItemLabels'];
                        ProductAttributeItemLabel::updateAll(['status' => ProductSku::STATUS_DELETED], ['store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                        foreach ($productAttributeItemLabels as $attributeValueId => $label) {
                            $modelTemp = ProductAttributeItemLabel::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id, 'attribute_item_id' => $attributeValueId])->one();
                            !$modelTemp && $modelTemp = new ProductAttributeItemLabel();
                            $modelTemp->product_id = $model->id;
                            $modelTemp->attribute_item_id = $attributeValueId;
                            $modelTemp->name = $mapAttributeItemIdName[$attributeValueId] ?? '-';
                            $modelTemp->type = $mapAttributeItemIdTye[$attributeValueId] ?? Attribute::TYPE_TEXT;
                            $modelTemp->label = $modelTemp->type == Attribute::TYPE_COLOR ? str_replace('#', '', $label) : $label;
                            $modelTemp->status = ProductAttributeItemLabel::STATUS_ACTIVE;

                            if (!$modelTemp->save()) {
                                Yii::$app->logSystem->db($modelTemp->errors);
                                throw new NotFoundHttpException($this->getError($modelTemp));
                            }
                        }

                        ProductAttributeItemLabel::deleteAll(['status' => ProductSku::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    } else { // 否则删除所有多属性数据
                        ProductAttributeItemLabel::deleteAll(['store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    }

                    // 计算参数
                    if ($model->param_id > 0 && isset($post['productParam'])) {
                        $params = $post['productParam'];

                        ProductParam::updateAll(['status' => ProductParam::STATUS_DELETED], ['store_id' => $this->getStoreId(), 'product_id' => $model->id]);

                        foreach ($params as $id => $content) {
                            $modelTemp = ProductParam::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id, 'param_id' => $id])->one();
                            !$modelTemp && $modelTemp = new ProductParam();
                            $modelTemp->product_id = $model->id;
                            $modelTemp->param_id = $id;
                            $modelTemp->name = $mapAllParamIdName[$id] ?? '-';
                            $modelTemp->content = $content;
                            $modelTemp->status = ProductParam::STATUS_ACTIVE;

                            if (!$modelTemp->save()) {
                                Yii::$app->logSystem->db($modelTemp->errors);
                                throw new NotFoundHttpException($this->getError($modelTemp));
                            }
                        }

                        ProductParam::deleteAll(['status' => ProductParam::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    } else {
                        ProductParam::deleteAll(['status' => ProductParam::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'product_id' => $model->id]);
                    }

                    $transaction->commit();
                    return $this->redirectSuccess(['index']);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return $this->redirectError($e->getMessage());
                }

            }
        }

        $model->isAttribute = $model->attribute_set_id > 0 ? 1 : 0;
        $attributes = $attributeItems = [];

        $mapAttributeIdName = ArrayHelper::map($attributes, 'id', 'name');
        $mapProductAttributeItemIdLabel = [];
        $mapProductAttributeItemAttributeItemIdLabel = [];
        if ($id > 0) {
            $productAttributeItemLabels = ProductAttributeItemLabel::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $id])->all();
            $mapProductAttributeItemIdLabel = ArrayHelper::map($productAttributeItemLabels, 'id', 'label');
            $mapProductAttributeItemAttributeItemIdLabel = ArrayHelper::map($productAttributeItemLabels, 'attribute_item_id', 'label');
        }

        if ($model->isAttribute > 0) {
            $attributeSet = AttributeSet::findOne($model->attribute_set_id);
            if (count($attributeSet->attributeSetAttributes) > 0) {
                $attributes = Attribute::find()
                    ->where(['store_id' => $this->getStoreId(), 'id' => ArrayHelper::getColumn($attributeSet->attributeSetAttributes, 'attribute_id')])
                    ->orderBy(['sort' => SORT_ASC])
                    ->with('attributeItems')
                    ->all();

                /*if ($id > 0) {
                    foreach ($attributes as &$attribute) {
                        foreach ($attribute->attributeItems as &$attributeValue) {
                            $attributeValue->label = $mapProductAttributeItemAttributeItemIdLabel[$attributeValue->id] ?? '';
                        }
                        unset($attributeValue);
                    }
                    unset($attribute);
                }*/
            }
        }

        // 计算已经启用的属性值
        $enableValueIds = [];
        $productSkus = [];
        $enableValues = [];
        if ($model->attribute_set_id > 0) {
            $productSkus = ProductSku::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $model->id])->asArray()->all();
            if ($productSkus) {
                $enableValueIds = array_unique(explode(',', implode(',', ArrayHelper::getColumn($productSkus, 'attribute_value'))));
            }
            $attributeItems = AttributeItem::find()->where(['store_id' => $this->getStoreId(), 'id' => $enableValueIds])->all();
            foreach ($attributeItems as $attributeItem) {
                $item = $attributeItem->attributes;
                $item['attribute_name'] = $mapAttributeIdName[$attributeItem->attribute_id] ?? '';
                $item['label'] = $mapProductAttributeItemIdLabel[$attributeItem->id] ?? '';

                $enableValues[] = $item;
            }
        }

        // 计算参数
        $productParams = [];
        if ($model->param_id > 0) {
            $productParams = ArrayHelper::map(ProductParam::find()->where(['store_id' => $this->getStoreId(), 'product_id' => $id])->all(), 'param_id', 'content');
        }

        $this->beforeEditRender($id, $model);
        $model->types = ArrayHelper::intToArray($model->type, $this->modelClass::getTypeLabels());
        $allTags = ArrayHelper::map(Tag::find()->where(['store_id' => $this->getStoreId(), 'status' => Tag::STATUS_ACTIVE])->asArray()->all(), 'id', 'name');
        $model->tags = ArrayHelper::getColumn(ProductTag::find()->filterWhere(['product_id' => $id])->asArray()->all(), 'tag_id');
        return $this->render($this->action->id, [
            'model' => $model,
            'attributes' => $attributes,
            'mapProductAttributeItemAttributeItemIdLabel' => $mapProductAttributeItemAttributeItemIdLabel,
            'enableValues' => $enableValues,
            'productSkus' => $productSkus,
            'allParams' => $allParams,
            'productParams' => $productParams,
            'allTags' => $allTags,
            'lang' => $lang,
        ]);
    }
}
