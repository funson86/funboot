<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use Yii;
use common\models\base\SettingType;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\data\ActiveDataProvider;

/**
 * SettingType
 *
 * Class SettingTypeController
 * @package backend\modules\base\controllers
 */
class SettingTypeController extends BaseController
{
    /**
      * @var SettingType
      */
    public $modelClass = SettingType::class;

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

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->parent_id == 0) {
            $model->parent_id = Yii::$app->request->get('parent_id', 0);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->cacheSystem->clearAllPermission(); // 清理缓存
                $this->flashSuccess();
            } else {
                $this->flashError($this->getError($model));
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }

    protected function afterDeleteModel($id, $soft = false, $tree = false)
    {
        Yii::$app->cacheSystem->clearAllSetting(); // 清理缓存
    }
}
