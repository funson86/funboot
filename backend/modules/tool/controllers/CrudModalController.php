<?php

namespace backend\modules\tool\controllers;

use Yii;
use common\models\tool\Crud;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Crud
 *
 * Class CrudModalController
 * @package backend\modules\tool\controllers
 */
class CrudModalController extends BaseController
{
    /**
      * @var Crud
      */
    public $modelClass = Crud::class;

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

    public function actionEditAjax()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->started_at = strtotime($post['Crud']['startedTime']);
            $model->ended_at = strtotime($post['Crud']['endedTime']);

            if (!$model->save()) {
                $this->redirectError($model);
            }

            return $this->redirectSuccess();
        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }

}
