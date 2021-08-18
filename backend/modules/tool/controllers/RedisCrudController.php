<?php

namespace backend\modules\tool\controllers;

use common\helpers\IdHelper;
use Yii;
use common\models\tool\RedisCrud;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Crud
 *
 * Class CrudController
 * @package backend\modules\tool\controllers
 */
class RedisCrudController extends BaseController
{
    protected $style = 3;

    /**
      * @var RedisCrud
      */
    public $modelClass = RedisCrud::class;

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
     * @param $id
     * @param bool $action
     * @return RedisCurd|null
     * @throws \Exception
     */
    protected function findModel($id, $action = false)
    {
        if (empty($id) || empty(($model = $this->modelClass::findOne($id)))) {
            $model = new $this->modelClass();
            $model->id = IdHelper::snowFlakeId();
            $model->sort = Yii::$app->params['defaultSort'];
            $model->status = $this->modelClass::STATUS_ACTIVE;

            return $model;
        }

        return $model;
    }

}
