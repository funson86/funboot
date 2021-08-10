<?php
namespace api\modules\v1\controllers;

use api\controllers\BaseController;
use api\models\User;

class UserController extends BaseController
{
    public $modelClass = User::class;
}
