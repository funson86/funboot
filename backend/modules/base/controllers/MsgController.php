<?php

namespace backend\modules\base\controllers;

use common\helpers\IdHelper;
use common\helpers\ImageHelper;
use common\helpers\Url;
use Yii;
use common\models\base\Message;
use backend\controllers\BaseController;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

/**
 * Message
 *
 * Class MsgController
 * @package backend\modules\base\controllers
 */
class MsgController extends BaseController
{
    public $pageSize = 25;

    /**
      * @var Message
      */
    public $modelClass = Message::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name'];

    /**
     * 可编辑字段
     *
     * @var int
     */
    protected $editAjaxFields = ['name', 'sort'];

    protected $forceStoreId = false;

    /**
     * 导入导出字段
     *
     * @var int
     */
    protected $exportFields = [
        'id' => 'text',
        'name' => 'text',
        'type' => 'select',
    ];

    protected function filterParams(&$params)
    {
        // inbox sent
        if (Yii::$app->request->get('box')) {
            unset($params['ModelSearch']['store_id']);
            $params['ModelSearch']['from_id'] = Yii::$app->user->id;
        } else {
            $params['ModelSearch']['user_id'] = Yii::$app->user->id;
        }

        $status = Yii::$app->request->get('status');
        if ($status) {
            $params['ModelSearch']['status'] = $status;
        } else {
            $params['ModelSearch']['status'] = '>' . $this->modelClass::STATUS_DELETED;
        }
    }

    protected function beforeView($id, $model)
    {
        if ($model->user_id != Yii::$app->user->id && $model->from_id != Yii::$app->user->id) {
            throw new NotFoundHttpException(Yii::t('app', 'No Auth'));
        }
        if ($model->status == $this->modelClass::STATUS_UNREAD && $model->user_id == Yii::$app->user->id) {
            $model->status = $this->modelClass::STATUS_READ;
            $model->save(false);
        }
    }

    /**
     * @param null $id
     * @param Message $model
     * @return bool|void
     */
    protected function beforeEdit($id = null, $model = null)
    {
        $model->user_id = Yii::$app->request->get('user_id');
        if ($id > 0 && $model->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException(Yii::t('app', 'No Auth'));
        }

        $model->message_type_id = Yii::$app->params['defaultMessageMessageTypeId'] ?? 3;
        $model->parent_id = Yii::$app->request->get('parent_id', 0);
        if ($model->parent_id > 0 && $model->parent) {
            $parent = $model->parent;
            $model->name = Yii::t('app', 'Reply: ') . $parent->name;
            if ($parent->status == $this->modelClass::STATUS_UNREAD && $parent->user_id == Yii::$app->user->id) {
                $parent->status = $this->modelClass::STATUS_READ;
                $parent->save(false);
                User::updateMessageCount(-1, $parent->user_id);
            }
        }
    }

    /**
     * @param null $id
     * @param Message $model
     * @return bool|void
     */
    protected function beforeEditSave($id = null, $model = null)
    {
        !$model->parent_id && $model->parent_id = 0;
        $model->from_id = Yii::$app->user->id;
        $this->isAdmin() && $model->type = Message::TYPE_MARKDOWN;

        if (!$model->user_id) {
            $model->user_id = 1;
        } elseif (is_array($model->user_id)) { // multiple user
            $userIds = $model->user_id;
            $model->user_id = intval(array_shift($userIds));
            $model->store_id = $model->user->store_id;
            foreach ($userIds as $userId) {
                $another = clone $model;
                $another->id = IdHelper::snowFlakeId();
                $another->user_id = intval($userId);
                $another->store_id = $another->user->store_id;
                $another->save();
            }
        }
        $model->store_id = $model->user->store_id;

        return true;
    }

    protected function afterEdit($id = null, $model = null)
    {
        User::updateMessageCount(1, $model->user_id);
    }

    /**
     * 列表页
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionList()
    {
        $status = Yii::$app->request->get('status', 0);
        $unread = Message::find()->where(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id, 'status' => Message::STATUS_UNREAD])->count();

        return $this->success([], ['unread' => $unread]);
    }
}
