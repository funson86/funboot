<?php

namespace backend\modules\bbs\controllers;

use Yii;
use common\models\bbs\Node;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Node
 *
 * Class NodeController
 * @package backend\modules\bbs\controllers
 */
class NodeController extends BaseController
{
    protected $style = 2;

    /**
      * @var Node
      */
    public $modelClass = Node::class;

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
