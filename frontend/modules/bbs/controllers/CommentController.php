<?php

namespace frontend\modules\bbs\controllers;

use common\helpers\StringHelper;
use common\models\bbs\Comment;
use common\models\bbs\Node;
use common\models\bbs\Topic;
use common\models\ModelSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Default controller for the `bbs` module
 */
class CommentController extends BaseController
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'delete-all' => ['post'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Comment();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if (!$model->topic->is_comment) {
                return $this->goBack();
            }

            $model->user_id = Yii::$app->user->id;
            if (!$model->save()) {
                return $this->redirectError();
            }

            $topic = $model->topic;
            $topic->last_comment_updated_at = time();
            $topic->last_comment_username = Yii::$app->user->identity->name ?: StringHelper::secretEmail(Yii::$app->user->identity->email);
            $topic->comment += 1;
            $topic->save();

            return $this->redirectSuccess();
        }

        return  $this->goBack();
    }

    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }

        $model = Comment::findOne($id);
        if (!$model || $model->store_id != $this->getStoreId() || !$model->isOwner()) {
            return $this->goBack();
        }

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if (!$model->save()) {
                return $this->redirectError();
            }

            return $this->redirectSuccess(['/bbs/topic/view', 'id' => $model->topic_id]);
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }

        $model = Comment::findOne($id);
        if (!$model || $model->store_id != $this->getStoreId() || !($model->isOwner() || $this->isManager())) {
            return $this->goBack();
        }

        if (!$model->delete()) {
            return $this->redirectError();
        }

        return $this->redirectSuccess();
    }
}
