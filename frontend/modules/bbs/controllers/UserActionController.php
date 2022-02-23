<?php

namespace frontend\modules\bbs\controllers;

use common\models\base\Profile;
use common\models\bbs\Comment;
use common\models\bbs\Topic;
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

    public function actionIndex()
    {
        $action = Yii::$app->request->get('action');
        $type = Yii::$app->request->get('type');
        $id = Yii::$app->request->get('id');
        if (!$action || !$type || !$id) {
            return $this->goBack();
        }

        $model = UserAction::find()->where(['user_id' => Yii::$app->user->id, 'action' => $action, 'type' => $type, 'target_id' => $id])->one();
        $counter = 1;
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
            $counter = -1;
            if (!$model->delete()) {
                return $this->error();
            }
        }

        $target = ($type == UserAction::TYPE_TOPIC ? Topic::findOne($id) : Comment::findOne($id));
        if ($target) {
            Profile::setFieldValue($target->user_id, UserAction::getActionProfileField($action), $counter, true);
        }

        return $this->redirectSuccess();
    }
}
