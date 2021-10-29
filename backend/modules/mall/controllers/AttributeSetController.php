<?php

namespace backend\modules\mall\controllers;

use common\models\mall\Attribute;
use common\models\mall\AttributeSetAttribute;
use Yii;
use common\models\mall\AttributeSet;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * AttributeSet
 *
 * Class AttributeSetController
 * @package backend\modules\mall\controllers
 */
class AttributeSetController extends BaseController
{
    /**
     * @var bool
     */
    public $isMultiLang = true;
    public $isAutoTranslation = true;

    /**
      * @var AttributeSet
      */
    public $modelClass = AttributeSet::class;

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

    protected function afterEdit($id = null, $model = null)
    {
        $post = Yii::$app->request->post();
        if (isset($post['Sub']) && is_array($post['Sub']) && count($post['Sub']) > 0) {
            AttributeSetAttribute::updateAll(['status' => AttributeSetAttribute::STATUS_DELETED], ['store_id' => $this->getStoreId(), 'attribute_set_id' => $id]);

            $sub = $post['Sub'];
            $length = isset($sub['sort']) ? count($sub['sort']) : 0;
            if ($length <= 0) {
                return;
            }
            for ($i = 0; $i < $length; $i++) {
                $modelTemp = AttributeSetAttribute::find()->where(['store_id' => $this->getStoreId(), 'attribute_set_id' => $id, 'attribute_id' => $sub['attribute_id'][$i]])->one();
                if (!$modelTemp) {
                    $modelTemp = new AttributeSetAttribute();
                    $modelTemp->attribute_set_id = $id;
                    $modelTemp->attribute_id = $sub['attribute_id'][$i];
                }
                $modelTemp->sort = $sub['sort'][$i];
                $modelTemp->status = AttributeSetAttribute::STATUS_ACTIVE;
                if (!$modelTemp->save()) {
                    Yii::$app->logSystem->db($modelTemp->errors);
                }
            }

            AttributeSetAttribute::deleteAll(['status' => AttributeSetAttribute::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'attribute_set_id' => $id]);
        }
    }

    /**
     * 获取属性和属性值
     * @param $id
     * @return array|mixed
     * @throws \Exception
     */
    public function actionViewAjaxValue($id)
    {
        $model = $this->findModel($id);
        if (!$model) {
            return $this->error();
        }

        $list = [];
        foreach ($model->attributeSetAttributes as $item) {
            $attribute = $item->attribute0;
            if ($attribute) {
                $item = $attribute->attributes;
                $values = [];
                foreach ($attribute->attributeItems as $value) {
                    $values[] = $value->attributes;
                }
                $item['attributeItems'] = $values;
            }

            $list[] = $item;
        }

        return $this->success($list);
    }
}
