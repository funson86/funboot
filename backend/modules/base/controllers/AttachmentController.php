<?php

namespace backend\modules\base\controllers;

use Yii;
use common\models\base\Attachment;
use backend\controllers\BaseController;

/**
 * Attachment
 *
 * Class AttachmentController
 * @package backend\modules\base\controllers
 */
class AttachmentController extends BaseController
{
    /**
      * @var Attachment
      */
    public $modelClass = Attachment::class;

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

}
