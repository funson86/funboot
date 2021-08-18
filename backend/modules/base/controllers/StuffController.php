<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use common\models\bbs\Node;
use common\models\Store;
use Yii;
use common\models\base\Stuff;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Stuff
 *
 * Class StuffController
 * @package backend\modules\base\controllers
 */
class StuffController extends BaseController
{
    /**
      * @var Stuff
      */
    public $modelClass = Stuff::class;

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
     * @param null $id
     * @param null|Stuff $model
     * @return bool|void
     */
    protected function beforeEdit($id = null, $model = null)
    {
        $models = [];
        $model->type = Yii::$app->request->get('type', $this->modelClass::TYPE_TEXT);
        $this->store->route == 'bbs' && $models = Node::find()->where(['status' => Node::STATUS_ACTIVE, 'store_id' => $this->getStoreId()])->asArray()->all();
        $model->mapCode = ArrayHelper::map($models, 'id', 'name');
    }
}
