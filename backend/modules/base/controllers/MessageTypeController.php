<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use common\models\base\Message;
use common\models\User;
use Yii;
use common\models\base\MessageType;

use backend\controllers\BaseController;

/**
 * Message
 *
 * Class MessageTypeController
 * @package backend\modules\base\controllers
 */
class MessageTypeController extends BaseController
{
    /**
      * @var Message
      */
    public $modelClass = MessageType::class;

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


    protected function beforeEditSave($id = null, $model = null)
    {
        $sendUsers = Yii::$app->request->post($model->formName())['sendUsers'] ?? null;
        if ($sendUsers && count($sendUsers) > 0) {
            $model->send_user = implode('|', $sendUsers);
        }
        $model->send_type = ArrayHelper::arrayToInt(Yii::$app->request->post($model->formName())['sendTypes'] ?? []);

        return true;
    }

    protected function afterEdit($id = null, $model = null)
    {
        if (!$id) { //编辑的新消息才发送
            Yii::$app->messageSystem->send($model, Yii::$app->user->id);
        }
    }

    protected function beforeEditRender($id = null, $model = null)
    {
        $model->sendUsers = explode('|', $model->send_user);
        $model->sendTypes = ArrayHelper::intToArray($model->send_type, $this->modelClass::getSendTypeLabels());
    }

    /**
     * @param $id
     * @return bool|void
     */
    protected function afterDeleteModel($id = null, $model = null, $soft = false, $tree = false)
    {
        if ($soft) {
            return Message::updateAll(['status' => Message::STATUS_DELETED], ['message_type_id' => $id]);
        } else {
            return Message::deleteAll(['message_type_id' => $id]);
        }
    }
}
