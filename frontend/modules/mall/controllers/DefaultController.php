<?php

namespace frontend\modules\mall\controllers;

/**
 * Default controller for the `mall` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render($this->action->id);
    }
}
