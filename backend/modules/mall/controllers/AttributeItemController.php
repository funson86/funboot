<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\AttributeItem;
use common\models\ModelSearch;

/**
 * AttributeItem
 *
 * Class AttributeItemController
 * @package backend\modules\mall\controllers
 */
class AttributeItemController extends BaseController
{
    /**
     * @var bool
     */
    public $isMultiLang = true;
    public $isAutoTranslation = true;

    /**
      * @var AttributeItem
      */
    public $modelClass = AttributeItem::class;

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

    /**
     * @param null $id
     * @param AttributeItem $model
     * @return bool|void
     */
    protected function beforeEditRender($id = null, $model = null)
    {
        $model->attribute_id = Yii::$app->request->get('attribute_id', 0);
    }

}
