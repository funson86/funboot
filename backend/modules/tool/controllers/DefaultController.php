<?php

namespace backend\modules\tool\controllers;

use backend\controllers\BaseController;

/**
 * Default controller for the `tool` module
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
