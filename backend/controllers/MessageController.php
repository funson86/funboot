<?php

namespace backend\controllers;

use common\helpers\ImageHelper;
use common\helpers\Url;
use Yii;
use common\models\base\Message;
use common\models\ModelSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\components\controller\BaseController;

/**
 * Message
 *
 * Class MessageController
 * @package backend\controllers
 */
class MessageController extends BaseController
{

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name'];

    /**
     * @var int
     */
    public $pageSize = 20;

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

    public function beforeAction($action)
    {
        $this->layout = 'main';
        parent::beforeAction($action);
        return true;
    }

    /**
      * 列表页
      * @param int $status
      * @return string
      * @throws \yii\web\NotFoundHttpException
      */
    public function actionIndex()
    {
        $status = Yii::$app->request->get('status', 0);
        $searchModel = new ModelSearch([
            'model' => Message::class,
            'scenario' => 'default',
            'likeAttributes' => $this->likeAttributes,
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['user_id'] = Yii::$app->user->id;
        $params['ModelSearch']['status'] = $status;
        $dataProvider = $searchModel->search($params);

        $unread = Message::find()->where(['user_id' => Yii::$app->user->id, 'status' => Message::STATUS_UNREAD])->count();

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'unread' => $unread,
        ]);
    }

    /**
      * 列表页
      * @return string
      * @throws \yii\web\NotFoundHttpException
      */
    public function actionList()
    {
        $status = Yii::$app->request->get('status', 0);
        $unread = Message::find()->where(['user_id' => Yii::$app->user->id, 'status' => Message::STATUS_UNREAD])->count();

        $models = Message::find()->where(['user_id' => Yii::$app->user->id, 'status' => Message::STATUS_UNREAD])
            ->with(['from' => function ($query) {
                $query->select(['id', 'username', 'avatar', 'name']);
            }])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(3)
            ->asArray()
            ->all();

        $list = [];
        foreach ($models as $model) {
            $item = $model;
            $item['url'] = Url::to(['message/view', 'id' => $model['id']], true);
            $item['avatar'] = ImageHelper::getAvatar($model['from']['avatar']);
            $item['username'] = strlen($model['from']['name']) > 0 ? $model['from']['name'] : $model['from']['username'];
            $item['created_at'] = (time() - $model['created_at']) > 86400 ? Yii::$app->formatter->asDatetime($model['created_at']) : Yii::$app->formatter->asRelativeTime($model['created_at']);

            $list[] = $item;
        }

        return $this->success($list, ['unread' => $unread]);
    }

    /**
     * 编辑/创建
     *
     * @return mixed
     */
    public function actionView()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $model = Message::findOne($id);
        if (!$model) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $model->status = Message::STATUS_READ;
        $model->save();

        $unread = Message::find()->where(['user_id' => Yii::$app->user->id, 'status' => Message::STATUS_UNREAD])->count();
        return $this->render($this->action->id, [
            'model' => $model,
            'unread' => $unread,
        ]);
    }

    /**
     * 删除
     *
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $model = Message::findOne($id);
        if (!$model) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $model->status = Message::STATUS_RECYCLE;
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return $this->redirectError($this->getError($model));
        }

        return $this->redirectSuccess(Yii::$app->request->referrer, Yii::t('app', 'Delete Successfully'));
    }
}
