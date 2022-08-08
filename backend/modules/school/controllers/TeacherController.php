<?php

namespace backend\modules\school\controllers;

use Yii;
use common\models\school\Teacher;
use backend\controllers\BaseController;

/**
 * Teacher
 *
 * Class TeacherController
 * @package backend\modules\school\controllers
 */
class TeacherController extends BaseController
{
    /**
      * @var Teacher
      */
    public $modelClass = Teacher::class;

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
