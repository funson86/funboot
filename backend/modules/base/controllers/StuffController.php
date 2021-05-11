<?php

namespace backend\modules\base\controllers;

use Yii;
use common\models\base\Stuff;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Stuff
 *
 * Class StuffController
 * @package backend\modules\base\controllers
 */
class StuffController extends BaseController
{
    /**
      * @var Stuff
      */
    public $modelClass = Stuff::class;

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
