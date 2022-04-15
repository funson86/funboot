<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\OrderLog;
use common\models\ModelSearch;

/**
 * OrderLog
 *
 * Class OrderLogController
 * @package backend\modules\mall\controllers
 */
class OrderLogController extends BaseController
{
    /**
      * @var OrderLog
      */
    public $modelClass = OrderLog::class;

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
