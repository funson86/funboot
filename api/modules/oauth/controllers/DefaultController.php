<?php

namespace api\modules\oauth\controllers;

use Yii;

/**
 * Default controller for the `oauth` module
 */
class DefaultController extends BaseController
{
    public $modelClass = '';

    public $skipModelClass = '*';

    public $optionalAuth = ['index'];

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return 'index';
    }

    public function actionProfile()
    {
        return Yii::$app->user->identity;
    }
}
