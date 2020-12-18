<?php
namespace api\controllers;

use api\modules\v1\models\User;
use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return 'funboot';
    }
}
