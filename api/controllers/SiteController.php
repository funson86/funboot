<?php
namespace api\controllers;

use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->success('funboot');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->success(['token' => 'abc']);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionMe()
    {
        return $this->success(['username' => 'funson', 'avatar' => 'https://inews.gtimg.com/newsapp_ls/0/12276089795_640330/0']);
    }

    public function actionError() {
        return 'error';
    }
}
