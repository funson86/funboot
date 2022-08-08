<?php

namespace backend\modules\tool\controllers;

use common\helpers\IdHelper;
use common\models\tool\ElasticsearchCrud;
use Yii;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * Crud
 *
 * Class CrudController
 * @package backend\modules\tool\controllers
 */
class ElasticsearchCrudController extends BaseController
{
    protected $style = 3;

    /**
      * @var ElasticsearchCrud
      */
    public $modelClass = ElasticsearchCrud::class;

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

    public function init()
    {
        //$this->modelClass::deleteIndex();
        $this->modelClass::updateMapping();

        parent::init();
    }

    /**
     * 列表页
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {

        $storeId = $this->isAdmin() ? null : $this->getStoreId();
        $data = $this->modelClass::find()
            ->andFilterWhere(['>', 'status', $this->modelClass::STATUS_DELETED])
            ->andFilterWhere(['store_id' => $storeId]);
        $filterArr = [];
        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => $this->pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_DESC])
            ->limit($pages->limit)
            ->query($filterArr)
            ->asArray()
            ->all();

        return $this->render($this->action->id, [
            'models' => $models,
            'pages' => $pages
        ]);

    }

    /**
     * @param $id
     * @return RedisCurd|null
     * @throws \Exception
     */
    protected function findModel($id = null)
    {
        if (is_null($id)) {
            $model = new $this->modelClass();
            $model->primaryKey = $model->id = IdHelper::snowFlakeId();
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
