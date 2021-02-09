<?php

namespace backend\modules\cms\controllers;

use Yii;
use common\models\cms\Page;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Page
 *
 * Class PageController
 * @package backend\modules\cms\controllers
 */
class PageController extends BaseController
{
    /**
      * @var Page
      */
    public $modelClass = Page::class;

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
