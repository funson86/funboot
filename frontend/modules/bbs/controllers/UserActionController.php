<?php

namespace frontend\modules\bbs\controllers;

use common\models\bbs\UserAction;
use yii\filters\AccessControl;
use Yii;

/**
 * Class UserActionController
 * @package frontend\modules\bbs\controllers
 * @author funson86 <funson86@gmail.com>
 */
class UserActionController extends BaseController
{

    /**
     * 行为控制
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($action, $type, $id)
    {
        $model = UserAction::find()->where(['user_id' => Yii::$app->user->id, 'action' => $action, 'type' => $type, 'target_id' => $id])->one();
        if (!$model) {
            $model = new UserAction([
                'user_id' => Yii::$app->user->id,
                'action' => $action,
                'type' => $type,
                'target_id' => $id
            ]);

            if (!$model->save()) {
                return $this->error();
            }
        } else {
            if (!$model->delete()) {
                return $this->error();
            }
        }

        return $this->redirectSuccess();
    }
}
