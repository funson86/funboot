<?php

namespace backend\modules\pay\controllers;

use Yii;
use common\models\pay\Payment;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Payment
 *
 * Class PaymentController
 * @package backend\modules\pay\controllers
 */
class PaymentController extends BaseController
{
    /**
      * @var Payment
      */
    public $modelClass = Payment::class;

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
