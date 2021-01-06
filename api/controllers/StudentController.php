<?php

namespace api\controllers;

use common\models\school\Student;
use common\models\User;
use yii\data\ActiveDataProvider;

/**
 * Class UserController
 * @package api\controllers
 * @author funson86 <funson86@gmail.com>
 */
class StudentController extends BaseController
{
    /**
     * @var string the model class name. This property must be set.
     */
    public $modelClass = Student::class;

    public $needAuth = false;
}