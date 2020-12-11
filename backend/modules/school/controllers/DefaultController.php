<?php

namespace backend\modules\school\controllers;

use backend\controllers\BaseController;

/**
 * Default controller for the `school` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->goHome();
    }
}
