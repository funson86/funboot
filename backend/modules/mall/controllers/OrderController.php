<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Order;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Order
 *
 * Class OrderController
 * @package backend\modules\mall\controllers
 */
class OrderController extends BaseController
{
    /**
      * @var Order
      */
    public $modelClass = Order::class;

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
