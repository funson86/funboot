<?php

namespace backend\modules\bbs\controllers;

use Yii;
use common\models\bbs\Topic;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Topic
 *
 * Class TopicController
 * @package backend\modules\bbs\controllers
 */
class TopicController extends BaseController
{
    /**
      * @var Topic
      */
    public $modelClass = Topic::class;

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
