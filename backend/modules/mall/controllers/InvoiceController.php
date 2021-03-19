<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Invoice;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Invoice
 *
 * Class InvoiceController
 * @package backend\modules\mall\controllers
 */
class InvoiceController extends BaseController
{
    /**
      * @var Invoice
      */
    public $modelClass = Invoice::class;

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
