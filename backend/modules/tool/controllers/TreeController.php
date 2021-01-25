<?php

namespace backend\modules\tool\controllers;

use Yii;
use common\models\tool\Tree;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Tree
 *
 * Class TreeController
 * @package backend\modules\tool\controllers
 */
class TreeController extends BaseController
{
    /**
     * 1带搜索列表 2树形 3非常规表格
     * @var array[]
     */
    protected $style = 2;

    /**
      * @var Tree
      */
    public $modelClass = Tree::class;

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
