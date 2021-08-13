<?php

namespace frontend\modules\chat\controllers;

use frontend\controllers\BaseController;

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
        return $this->render($this->action->id, []);
    }
}
