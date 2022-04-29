<?php

namespace backend\modules\base\controllers;

use Yii;
use common\models\base\Message;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Message
 *
 * Class MessageController
 * @package backend\modules\base\controllers
 */
class MessageController extends BaseController
{
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
        if (!$this->isAdmin()) {
            $params['ModelSearch']['store_id'] = $this->getStoreId();
            (!isset($params['ModelSearch']['status']) || is_null($params['ModelSearch']['status'])) && $params['ModelSearch']['status'] = '>' . $this->modelClass::STATUS_DELETED;
        }
        Yii::$app->request->get('message_type_id') && $params['ModelSearch']['message_type_id'] = Yii::$app->request->get('message_type_id');
    }
}
