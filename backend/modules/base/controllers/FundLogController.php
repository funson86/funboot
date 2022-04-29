<?php

namespace backend\modules\base\controllers;

use Yii;
use common\models\base\FundLog;

use backend\controllers\BaseController;

/**
 * FundLog
 *
 * Class FundLogController
 * @package backend\modules\base\controllers
 */
class FundLogController extends BaseController
{
    /**
      * @var FundLog
      */
    public $modelClass = FundLog::class;

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
