<?php

namespace backend\modules\base\controllers;

use Yii;
use common\models\base\Recharge;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Recharge
 *
 * Class RechargeController
 * @package backend\modules\base\controllers
 */
class RechargeController extends BaseController
{
    /**
      * @var Recharge
      */
    public $modelClass = Recharge::class;

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
