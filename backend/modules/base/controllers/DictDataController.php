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
    public $likeAttributes = ['name', 'code', 'value', 'brief'];

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
        $params['ModelSearch']['status'] = '>' . $this->modelClass::STATUS_DELETED;
    }

    protected function beforeEdit($id = null, $model = null)
    {
        // 判断必须有dict_id
        if (!$model->dict_id) {
            $model->dict_id = Yii::$app->request->get('dict_id', null);
            if (!$model->dict_id) {
                return $this->redirectError(Yii::t('app', 'Plese select dict first'));
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
    }

    protected function afterEdit($id = null, $model = null)
    {
        $this->clearCache();
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
        if (!$model) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                $this->redirectError($this->getError($model));
            }

            $this->clearCache();
            return $this->redirectSuccess();
        }

        return $this->renderAjax(Yii::$app->request->get('view') ?? $this->viewFile ?? $this->action->id, [
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
    public function actionDeleteDict()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $model = Dict::findOne($id);
        if (!$model) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));;
        }

        if (!$model->delete()) {
            Yii::$app->logSystem->db($model->errors);
            return $this->redirectError();
        }

        $this->clearCache();
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
        if (empty($id)) {
            $model = new Dict();
            return $model->loadDefaultValues();
        } else {
            $model = Dict::findOne($id);
        }

        return $model;
    }

    protected function clearCache()
    {
        return Yii::$app->cacheSystem->clearAllDict();
    }
}
