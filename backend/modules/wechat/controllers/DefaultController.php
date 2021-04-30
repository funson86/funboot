<?php

namespace backend\modules\wechat\controllers;

use backend\controllers\BaseController;

/**
 * Default controller for the `wechat` module
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
