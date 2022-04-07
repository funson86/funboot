<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use common\models\base\Message;
use common\models\User;
use Yii;
use common\models\base\MessageType;
use common\models\ModelSearch;
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

    /**
      * ajax编辑/创建
      *
      * @return mixed|string|\yii\web\Response
      * @throws \yii\base\ExitException
      */
    public function actionEditAjax()
    {
        $id = Yii::$app->request->get('id', null);
        $model = $this->findModel($id);

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            $sendUsers = Yii::$app->request->post($model->formName())['sendUsers'] ?? null;
            if ($sendUsers && count($sendUsers) > 0) {
                $model->send_user = implode('|', $sendUsers);
            }
            $model->send_type = ArrayHelper::arrayToInt(Yii::$app->request->post($model->formName())['sendTypes'] ?? []);

            if (!$model->save()) {
                $this->redirectError($this->getError($model));
            }

            if (!$id) { //编辑的新消息才发送
                Yii::$app->messageSystem->send($model, Yii::$app->user->id);
            }
            return $this->redirectSuccess();
        }

        $model->sendUsers = explode('|', $model->send_user);
        $model->sendTypes = ArrayHelper::intToArray($model->send_type, $this->modelClass::getSendTypeLabels());
        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return bool|void
     */
    protected function afterDeleteModel($id, $model = null, $soft = false, $tree = false)
    {
        if ($soft) {
            return Message::updateAll(['status' => Message::STATUS_DELETED], ['message_type_id' => $id]);
        } else {
            return Message::deleteAll(['message_type_id' => $id]);
        }
    }
}
