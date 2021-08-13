<?php

namespace backend\modules\chat\controllers;

use Yii;
use common\models\chat\Log;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Log
 *
 * Class LogController
 * @package backend\modules\chat\controllers
 */
class LogController extends BaseController
{
    /**
      * @var Log
      */
    public $modelClass = Log::class;

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
