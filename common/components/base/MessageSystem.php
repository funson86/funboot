<?php
namespace common\components\base;

use common\job\base\MessageJob;
use common\models\base\Message;
use common\models\base\MessageType;
use common\models\User;
use Yii;

/**
 * Class MessageSystem
 * @author funson86 <funson86@gmail.com>
 */
class MessageSystem extends \yii\base\Component
{
    public $queue = false;

    /**
     * @param Message $model
     * @param $toId
     */
    public function send(Message $model)
    {
        // 插入队列
        if ($this->queue) {
            Yii::$app->queue->push(new MessageJob(['model' => $model]));
        } else {
            $this->insert($model);
        }
    }

    /**
     * @param MessageType $messageType
     * @param int $fromId
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public function sendMessageType(MessageType $messageType, $fromId = 1)
    {
        if (!$messageType) {
            return false;
        }

        $users = [];
        if ($messageType->send_target == MessageType::SEND_TARGET_ALL) {
            $users = User::find()->select(['id', 'store_id'])->asArray()->all();
        } else {
            $arrUser = explode('|', $messageType->send_user);
            $users = User::find()->where(['id' => $arrUser])->select(['id', 'store_id'])->asArray()->all();
        }

        if (count($users) <= 0) {
            return false;
        }

        foreach ($users as $user) {

            $model = new Message();
            $model->store_id = $user['store_id'];
            $model->message_type_id = $messageType->id;
            $model->name = $messageType->name;
            $model->user_id = $user['id'];
            $model->from_id = $fromId;
            $model->status = Message::STATUS_UNREAD;

            // 插入队列
            if ($this->queue) {
                Yii::$app->queue->push(new MessageJob(['model' => $model]));
            } else {
                $this->insert($model);
            }
        }

        return true;
    }

    /**
     * @param Message $model
     * @throws \yii\base\InvalidConfigException
     */
    public function insert(Message $model)
    {
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
        }

        User::updateMessageCount(1, $model->user_id);
        return true;
    }

}
