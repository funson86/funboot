<?php

namespace backend\modules\school\controllers;

use Yii;
use common\models\school\Student;
use backend\controllers\BaseController;

/**
 * Student
 *
 * Class StudentController
 * @package backend\modules\school\controllers
 */
class StudentController extends BaseController
{
    /**
      * @var Student
      */
    public $modelClass = Student::class;

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
