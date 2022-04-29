<?php

namespace backend\modules\base\controllers;

use Yii;
use common\models\base\PointLog;

use backend\controllers\BaseController;

/**
 * PointLog
 *
 * Class PointLogController
 * @package backend\modules\base\controllers
 */
class PointLogController extends BaseController
{
    /**
      * @var PointLog
      */
    public $modelClass = PointLog::class;

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
