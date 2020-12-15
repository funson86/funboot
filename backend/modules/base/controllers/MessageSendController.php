<?php

namespace backend\modules\base\controllers;

use Yii;
use common\models\base\MessageSend;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * MessageSend
 *
 * Class MessageSendController
 * @package backend\modules\base\controllers
 */
class MessageSendController extends BaseController
{
    /**
      * @var MessageSend
      */
    public $modelClass = MessageSend::class;

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
      * 列表页
      * @param int $messageId
      * @return string
      * @throws \yii\web\NotFoundHttpException
      */
    public function actionIndex($messageId = 0)
    {
        $searchModel = new ModelSearch([
            'model' => $this->modelClass,
            'scenario' => 'default',
            'likeAttributes' => $this->likeAttributes,
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        $params = Yii::$app->request->queryParams;
        if ($messageId > 0) {
            $params['ModelSearch']['message_id'] = $messageId;
        }
        // 管理员级别才能查看所有数据，其他只能查看本store数据
        $params = Yii::$app->request->queryParams;
        if (!$this->isAdmin()) {
            $params['ModelSearch']['store_id'] = $this->getStoreId();
        }
        $dataProvider = $searchModel->search($params);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

}
