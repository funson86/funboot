<?php
namespace api\controllers;

use Yii;
use api\components\Controller;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
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
        return 'funboot';
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->success(null, ['token' => 'abc']);
        return '{"result":"8c008f1599944d6f9537805ed303447b","code":200,"success":true,"message":"登录成功","timestamp":1596788169944}';
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
