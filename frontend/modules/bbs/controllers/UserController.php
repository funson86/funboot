<?php

namespace frontend\modules\bbs\controllers;

use common\components\uploader\Uploader;
use common\job\base\CounterJob;
use common\models\base\Attachment;
use common\models\bbs\Comment;
use common\models\bbs\Topic;
use common\models\bbs\UserAction;
use common\models\forms\ChangePasswordForm;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Class UserController
 * @package frontend\modules\bbs\controllers
 * @author funson86 <funson86@gmail.com>
 */
class UserController extends BaseController
{
    public $modelClass = User::class;

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
                'only' => ['profile', 'avatar', 'change-password'],
                'rules' => [
                    [
                        'actions' => ['profile', 'avatar', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionView($id)
    {
        $model = $this->findModel($id, true);
        if (!$model || $model->status != $this->modelClass::STATUS_ACTIVE) {
            return $this->goBack();
        }

        $type = Yii::$app->request->get('type');
        if (!$type) {
            return $this->redirect(['/bbs/user/view', 'id' => $id, 'type' => 'index']);
        }
        if ($type == 'topic') {
            $dataProvider = new ActiveDataProvider([
                'query' => Topic::find()->where(['store_id' => $this->getStoreId(), 'user_id' => $id, 'status' => Comment::STATUS_ACTIVE])->orderBy(['id' => SORT_DESC])
            ]);
        } elseif ($type == 'favorite') {
            $dataProvider = new ActiveDataProvider([
                'query' => UserAction::find()->where(['store_id' => $this->getStoreId(), 'user_id' => $id, 'action' => UserAction::ACTION_FAVORITE])->orderBy(['id' => SORT_DESC])
            ]);
        } elseif ($type == 'like') {
            $dataProvider = new ActiveDataProvider([
                'query' => UserAction::find()->where(['store_id' => $this->getStoreId(), 'user_id' => $id, 'action' => UserAction::ACTION_LIKE])->orderBy(['id' => SORT_DESC])
            ]);
        } elseif ($type == 'point') {
            $dataProvider = new ActiveDataProvider([
                //'query' => Point::find()->where(['store_id' => $this->getStoreId(), 'user_id' => $id, 'status' => Comment::STATUS_ACTIVE])->orderBy(['id' => SORT_DESC])
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Comment::find()->where(['store_id' => $this->getStoreId(), 'user_id' => $id, 'status' => Comment::STATUS_ACTIVE])->orderBy(['id' => SORT_DESC])
            ]);
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->redirectSuccess([$this->action->id]);
                } else {
                    Yii::$app->logSystem->db($model->errors);
                }
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionAvatar()
    {
        $model = Yii::$app->user->identity;

        if (Yii::$app->request->isPost) {
            $uploader = new Uploader(Yii::$app->request->post(), Attachment::UPLOAD_TYPE_IMAGE);
            $uploader->uploadFileName = 'User[avatar]';
            if ($data = $uploader->save()) {
                $model->avatar = $data['url'] ?? '';
                if ($model->save()) {
                    return $this->redirectSuccess();
                } else {
                    Yii::$app->logSystem->db($model->errors);
                }
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
            Yii::$app->user->logout();
            return $this->redirectSuccess(['/bbs/default/login']);
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionBlackList()
    {
        $id = Yii::$app->request->get('id');
        if (!$this->isManager() || !$id) {
            return $this->goBack();
        }

        $model = $this->findModel($id, true);
        if (!$model) {
            return $this->goBack();
        }

        $model->status = $this->modelClass::STATUS_INACTIVE;
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return $this->redirectError();
        }

        return $this->redirectSuccess();
    }
}