<?php

namespace backend\modules\bbs\controllers;

use Yii;
use common\models\bbs\SearchLog;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * SearchLog
 *
 * Class SearchLogController
 * @package backend\modules\bbs\controllers
 */
class SearchLogController extends BaseController
{
    /**
      * @var SearchLog
      */
    public $modelClass = SearchLog::class;

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
