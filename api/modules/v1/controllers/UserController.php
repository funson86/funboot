<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use common\models\User;
use yii\web\Response;

class UserController extends Controller
{
    public $modelClass = 'api\modules\v1\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actionLogin()
    {
        $result = false;
        $token = '';
        $accessToken = Yii::$app->request->get('access_token');
        if ($accessToken) {
            if (User::findOne(['access_token' => $accessToken])) {
                $result = true;
            }
        } elseif (Yii::$app->request->post('username') && Yii::$app->request->post('password')) {
            $user = User::findByUsername(Yii::$app->request->post('username'));

            if ($user && $user->validatePassword(Yii::$app->request->post('password'))) {
                if ($user->access_token) {
                    $token = $user->access_token;
                } else {
                    $token = hash('sha256', Yii::$app->request->get('username'));
                    Yii::$app->db->createCommand()->update("user", ['access_token' => $token], 'id = ' . $user->id)->execute();
                }

                $result = true;
            }
        }

        if ($result) {
            return [
                'result' => 'success',
                'access_token' => $token,
            ];
        } else {
            return [
                'result' => 'failed',
            ];
        }
    }
}
