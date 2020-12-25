<?php
namespace common\components\base;

use common\job\base\MessageJob;
use common\models\base\Message;
use common\models\base\MessageSend;
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
     * @param int $fromId
     * @return array|bool
     */
    public function send(Message $message, $fromId = 1)
    {
        if (!$message) {
            return false;
        }

        $users = [];
        if ($message->send_target == Message::SEND_TARGET_ALL) {
            $users = User::find()->all();
        } else {
            $arrUser = explode('|', $message->send_user);
            $users = User::find()->where(['id' => $arrUser])->all();
        }

        if (count($users) <= 0) {
            return false;
        }

        foreach ($users as $user) {

            $model = new MessageSend();
            $model->store_id = $user->store_id;
            $model->message_id = $message->id;
            $model->name = $message->name;
            $model->user_id = $user->id;
            $model->from_id = $fromId;

            // 插入队列
            if ($this->queue) {
                Yii::$app->queue->push(new MessageJob(['model' => $model]));
            } else {
                $this->insert($model);
            }
        }

        return true;
    }

    public function insert($model)
    {
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
        }
    }

}