<?php

namespace backend\modules\base\controllers;

use common\helpers\IdHelper;
use common\models\base\Dict;
use Yii;
use common\models\base\DictData;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
* DictData
*
* Class DictDataController
* @package backend\modules\base\controllers
*/
class DictDataController extends BaseController
{
    /**
    * @var DictData
    */
    public $modelClass = DictData::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name', 'description'];

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
    *
    * @return string
    * @throws \yii\web\NotFoundHttpException
    */
    public function actionIndex()
    {
        $dicts = Dict::find()->all();
        $dictId = Yii::$app->request->get('ModelSearch')['dict_id'] ?? 0;

        $searchModel = new ModelSearch([
            'model' => $this->modelClass,
            'scenario' => 'default',
            'likeAttributes' => $this->likeAttributes,
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        // 管理员级别才能查看所有数据，其他只能查看本store数据
        $params = Yii::$app->request->queryParams;
        if (!$this->isAdmin()) {
            $params['ModelSearch']['store_id'] = $this->getStoreId();
            $params['ModelSearch']['status'] = '>' . $this->modelClass::STATUS_DELETED;
        }
        $dataProvider = $searchModel->search($params);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'dicts' => $dicts,
            'dictId' => $dictId,
        ]);
    }

    /**
     * ajax编辑/创建
     *
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionEditAjax()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        // 判断必须有dict_id
        if (!$model->dict_id) {
            $model->dict_id = Yii::$app->request->get('dict_id', null);
            if (!$model->dict_id) {
                return $this->redirectError(Yii::t('app', 'Invalid id'));
            }
        }

        //给定前缀
        if (!$model->name) {
            $dict = Dict::findOne($model->dict_id);
            $model->name = $dict->name;
            if (!$model->code) {
                $model->code = $dict->code . '_';
            }
        }

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                $this->redirectError($model);
            }

            Yii::$app->cacheSystem->clearDict();
            return $this->redirectSuccess();
        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * ajax编辑/创建
     *
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionEditAjaxDict()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findDict($id);

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                $this->redirectError($model);
            }

            Yii::$app->cacheSystem->clearDict();
            return $this->redirectSuccess();
        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * 删除
     *
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteDict($id)
    {
        $model = Dict::findOne($id);
        if (!$model) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));;
        }

        if (!$model->delete()) {
            Yii::$app->logSystem->db($model->errors);
            return $this->redirectError();
        }

        Yii::$app->cacheSystem->clearDict();
        return $this->redirectSuccess(Yii::$app->request->referrer, Yii::t('app', 'Delete Successfully'));
    }

    /**
     * 返回模型
     *
     * @param $id
     * @return \yii\db\ActiveRecord
     */
    protected function findDict($id)
    {
        /* @var $model \yii\db\ActiveRecord */
        if (empty($id) || empty(($model = Dict::findOne($id)))) {
            $model = new Dict();
            $model->id = IdHelper::snowFlakeId();
            $model->store_id = $this->getStoreId();

            return $model->loadDefaultValues();
        }

        return $model;
    }

}
