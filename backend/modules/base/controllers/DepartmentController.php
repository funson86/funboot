<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use Yii;
use common\models\base\Department;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * Department
 *
 * Class DepartmentController
 * @package backend\modules\base\controllers
 */
class DepartmentController extends BaseController
{
    /**
      * @var Department
      */
    public $modelClass = Department::class;

    /**
     * 1带搜索列表 2树形 3非常规表格
     * @var array[]
     */
    protected $style = 2;

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
      * 列表页
      *
      * @return string
      * @throws \yii\web\NotFoundHttpException
      */
    public function actionIndex()
    {
        $query = $this->modelClass::find()
            ->where(['store_id' => $this->getStoreId()])
            ->orderBy(['id' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
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

        $model->parent_id == 0 && $model->parent_id = Yii::$app->request->get('parent_id', 0);
        $allUsers = User::getIdLabel(false, 'username');

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            $heads = Yii::$app->request->post($model->formName())['heads'] ?? [];
            if (is_array($heads) && count($heads) > 0) {
                $model->head = implode('|', $heads);
            }

            $viceHeads = Yii::$app->request->post($model->formName())['viceHeads'] ?? [];
            if (is_array($heads) && count($viceHeads) > 0) {
                $model->vice_head = implode('|', $viceHeads);
            }

            if (!$model->save()) {
                $this->redirectError($this->getError($model));
            }

            return $this->redirectSuccess();
        }

        $model->heads = explode('|', $model->head);
        $model->viceHeads = explode('|', $model->vice_head);
        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'allUsers' => $allUsers,
        ]);
    }

    /**
     * @param $id
     * @return bool|void
     */
    protected function afterDeleteModel($id, $model = null, $soft = false, $tree = false)
    {
        Yii::$app->cacheSystem->clearAllPermission(); // 清理缓存
    }
}
