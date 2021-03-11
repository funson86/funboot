<?php

namespace backend\modules\cms\controllers;

use common\models\cms\Page;
use Yii;
use common\models\cms\Catalog;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Catalog
 *
 * Class CatalogController
 * @package backend\modules\cms\controllers
 */
class CatalogController extends BaseController
{
    protected $style = 2;

    /**
      * @var Catalog
      */
    public $modelClass = Catalog::class;

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

        $model->parent_id == 0 && $model->parent_id = Yii::$app->request->get('parent_id', 0);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
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

    protected function beforeDeleteModel($id, $soft = false, $tree = false)
    {
        if (!$soft) {
            Page::deleteAll(['catalog_id' => $id]);
        }
    }
}
