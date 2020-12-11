<?php
/**
 * Created by PhpStorm.
 * User: funson
 * Date: 2014/12/25
 * Time: 17:08
 */

namespace api\modules\v2\controllers;

use yii\rest\Controller;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use api\modules\v2\models\Post;
use yii\filters\auth\HttpBasicAuth;

class PostController extends ActiveController
{
    public $modelClass = 'api\modules\v2\models\Post';
    /*public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];*/

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        /*$behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];*/
        return $behaviors;
    }

    /*public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Post::find(),
        ]);
    }

    /*public function actionView($id)
    {
        return Post::findOne($id);
    }*/

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['view']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Post::find(),
        ]);
        // prepare and return a data provider for the "index" action
    }

}
