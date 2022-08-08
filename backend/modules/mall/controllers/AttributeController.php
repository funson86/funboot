<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Attribute;
use common\models\ModelSearch;

/**
 * Attribute
 *
 * Class AttributeController
 * @package backend\modules\mall\controllers
 */
class AttributeController extends BaseController
{
    /**
     * @var bool
     */
    public $isMultiLang = true;
    public $isAutoTranslation = true;

    /**
      * @var Attribute
      */
    public $modelClass = Attribute::class;

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

}
