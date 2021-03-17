<?php

namespace backend\modules\mall\controllers;

use common\models\mall\Attribute;
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

    public function actionViewAjaxValue($id)
    {
        $model = $this->findModel($id);
        if (!$model) {
            return $this->error();
        }

        $list = [];
        foreach ($model->attribute_ids as $id) {
            $attribute = Attribute::findOne($id);
            if ($attribute) {
                $item = $attribute->attributes;
                $values = [];
                foreach ($attribute->attributeValues as $value) {
                    $values[] = $value->attributes;
                }
                $item['values'] = $values;
            }

            $list[] = $item;
        }

        return $this->success($list);
    }
}
