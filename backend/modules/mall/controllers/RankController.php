<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Rank;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Comment
 *
 * Class CommentController
 * @package backend\modules\mall\controllers
 */
class RankController extends BaseController
{
    /**
      * @var Rank
      */
    public $modelClass = Rank::class;

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
