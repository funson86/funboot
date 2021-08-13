<?php

namespace console\modules\chat\controllers;

use console\controllers\BaseController;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        echo 'chat';
    }
}
