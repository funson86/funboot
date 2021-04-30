<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Category;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Category
 *
 * Class CategoryController
 * @package backend\modules\mall\controllers
 */
class CategoryController extends BaseController
{
    /**
     * 1带搜索列表 2树形(不分页) 3非常规表格
     * @var array[]
     */
    protected $style = 2;

    /**
      * @var Category
      */
    public $modelClass = Category::class;

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
