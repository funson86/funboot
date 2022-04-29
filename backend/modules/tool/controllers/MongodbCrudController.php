<?php

namespace backend\modules\tool\controllers;

use common\helpers\IdHelper;
use common\models\tool\MongodbCrud;
use Yii;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;

/**
 * Crud
 *
 * Class CrudController
 * @package backend\modules\tool\controllers
 */
class MongodbCrudController extends BaseController
{
    protected $style = 3;

    /**
      * @var MongodbCrud
      */
    public $modelClass = MongodbCrud::class;

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
     * @return MongodbCrud|null
     * @throws \Exception
     */
    protected function findModel($id = null)
    {
        if (is_null($id)) {
            $model = new $this->modelClass();
            $model->_id = $model->id = IdHelper::snowFlakeId();
            $model->sort = Yii::$app->params['defaultSort'];
            $model->status = $this->modelClass::STATUS_ACTIVE;
        } else {
            $model = $this->modelClass::findOne($id);

            if (!$model) {
                throw new NotFoundHttpException(Yii::t('app', 'Invalid id'), 500);
            }
        }

        return $model;
    }

}
