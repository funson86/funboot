<?php

namespace api\modules\v2\controllers;

use api\controllers\BaseController;

/**
 * Default controller for the `v2` module
 */
class DefaultController extends BaseController
{
    public function actionIndex()
    {
        return $this->success('v2');
    }
}
