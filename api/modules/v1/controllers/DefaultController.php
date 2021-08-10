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

    /**
     * @OA\Get(
     *     path="/v1/default/index",
     *     @OA\Response(response="200", description="default action for /v1")
     * )
     */
    public function actionIndex()
    {
        return $this->success('v1');
    }

    public function actionLogin()
    {
        $model = new LoginEmailForm();
        $model->attributes = Yii::$app->request->post();
        if ($model->validate()) {
            return $this->success(Yii::$app->accessTokenSystem->refreshAccessToken($model->getUser()));
        }

        return $this->error();
    }
}
