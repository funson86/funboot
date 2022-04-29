<?php

namespace backend\modules\base\controllers;

use Yii;
use common\models\oauth\Client;

use backend\controllers\BaseController;

/**
 * Client
 *
 * Class ClientController
 * @package backend\modules\base\controllers
 */
class ClientController extends BaseController
{
    /**
      * @var Client
      */
    public $modelClass = Client::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name', 'client_id', 'redirect_uri', 'brief'];

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

}
