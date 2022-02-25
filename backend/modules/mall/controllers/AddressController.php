<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Address;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Address
 *
 * Class AddressController
 * @package backend\modules\mall\controllers
 */
class AddressController extends BaseController
{
    /**
      * @var Address
      */
    public $modelClass = Address::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name', 'first_name', 'last_name'];

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
