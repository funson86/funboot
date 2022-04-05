<?php
namespace api\controllers;

use api\models\forms\RefreshForm;
use api\models\LoginForm;
use api\modules\v1\models\User;
use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

/**
 * @OA\Info(title="Site", version="1.0")
 */
/**
 * Site controller
 */
class SiteController extends BaseController
{
    public $modelClass = '';

    public $skipModelClass = '*';

    public $optionalAuth = ['error', 'index', 'login', 'refresh'];

    /**
     * @return string
     */
    public function actionError()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            $exception = new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return Yii::$app->responseSystem->error($exception->getCode(), $exception->getMessage());
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
     * @OA\Post(path="/api/site/login",
     *     tags={"Site"},
     *     summary="Login",
     *     description="Logs user into the system",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/x-www-form-urlencoded",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(property="username", description="Username", type="string"),
     *               @OA\Property(property="password", description="Password", type="string"),
     *           )
     *       )
     *     ),
     *     @OA\Response(response="200",description="Success"),
     *     @OA\Response(response="422",description="Input Parameter Error"),
     * )
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->attributes = Yii::$app->request->post();
        if ($model->validate()) {
            return Yii::$app->accessTokenSystem->getAccessToken($model->getUser());
        }

        return $this->error();
    }

    /**
     * @OA\Post(path="/api/site/refresh",
     *     tags={"Site"},
     *     summary="Refresh user access token",
     *     description="Refresh user access token",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/x-www-form-urlencoded",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(property="refresh_token", description="Refresh Token in login", type="string"),
     *           )
     *       )
     *     ),
     *     @OA\Response(response="200",description="Success"),
     *     @OA\Response(response="422",description="Input Parameter Error"),
     * )
     */
    public function actionRefresh()
    {
        $model = new RefreshForm();
        $model->attributes = Yii::$app->request->post();
        if ($model->validate()) {
            return Yii::$app->accessTokenSystem->getAccessToken($model->getUser());
        }

        return $this->error();
    }

    /**
     * @OA\Get(path="/api/site/logout",
     *     tags={"Site"},
     *     summary="Logout",
     *     description="Logout",
     *     @OA\Parameter(name="access-token", required=true, @OA\Schema(type="string"), in="header", description="login access token"),
     *     @OA\Response(response="200",description="Success"),
     *     @OA\Response(response="401",description="Unauthorized"),
     * )
     */
    public function actionLogout()
    {
        if (Yii::$app->accessTokenSystem->disableAccessToken(Yii::$app->user->identity->access_token)) {
            return '';
        }

        return $this->error();
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionProfile()
    {
        return 'profile';
    }

}
