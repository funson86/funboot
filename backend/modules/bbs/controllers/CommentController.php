<?php

namespace backend\modules\bbs\controllers;

use Yii;
use common\models\bbs\Comment;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Comment
 *
 * Class CommentController
 * @package backend\modules\bbs\controllers
 */
class CommentController extends BaseController
{
    /**
      * @var Comment
      */
    public $modelClass = Comment::class;

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
