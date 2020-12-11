<?php
namespace api\modules\v2\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * @V2\User(title="v2", version="0.2")
 */

/**
 * @OA\Get(
 *     path="/api/resource1.json",
 *     @OA\Response(response="200", description="An example resource")
 * )
 */
class UserController extends ActiveController
{
    public $modelClass = 'api\modules\v2\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actionSearch($str)
    {
        return [
            [
                'id' => 5,
                'version' => "5.5",
                'name' => "Angry Birds",
            ],
            [
                'id' => 6,
                'version' => "6.5",
                'name' => "Hello World",
            ],
            [
                'id' => 7,
                'version' => "7.5",
                'name' => "Happy Sky",
            ],
        ];
    }

    /*public function actionLogin()
    {
        //return Yii::$app->request->post('username');
        return [
            'result' => 'success',
            'access_token' => 'abc',
        ];
    }*/
}
