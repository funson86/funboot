<?php

namespace api\modules\v1\controllers;

use api\controllers\BaseController;
use api\models\forms\LoginEmailForm;
use Yii;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends BaseController
{
    public $modelClass = '';
    public $skipModelClass = '*';

    public $optionalAuth = ['index', 'login'];

    public function actionIndex()
    {
        return $this->success('v1');
    }

    public function actionLogin()
    {
        $model = new LoginEmailForm();
        $model->attributes = Yii::$app->request->post();
        if ($model->validate()) {
            return Yii::$app->accessTokenSystem->getAccessToken($model->getUser());
        }

        return $this->error();
    }

    public function actionCheckAccess()
    {
        return $this->success(Yii::$app->user->identity);
    }
}
