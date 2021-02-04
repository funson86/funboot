<?php

namespace backend\modules\tool\controllers;

use Yii;
use common\models\tool\Crud;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Crud
 *
 * Class CrudController
 * @package backend\modules\tool\controllers
 */
class CrudController extends BaseController
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


    /**
     * 编辑/创建
     *
     * @return mixed
     */
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id', null);
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $post = Yii::$app->request->post();
                $model->started_at = strtotime($post['Crud']['startedTime']);
                $model->ended_at = strtotime($post['Crud']['endedTime']);

                if ($model->save()) {
                    return $this->redirectSuccess(['index']);
                } else {
                    Yii::$app->logSystem->db($model->errors);
                }
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

}
