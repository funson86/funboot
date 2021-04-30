<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Consultation;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Consultation
 *
 * Class ConsultationController
 * @package backend\modules\mall\controllers
 */
class ConsultationController extends BaseController
{
    /**
      * @var Consultation
      */
    public $modelClass = Consultation::class;

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
