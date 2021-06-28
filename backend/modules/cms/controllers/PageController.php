<?php

namespace backend\modules\cms\controllers;

use Yii;
use common\models\cms\Page;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Page
 *
 * Class PageController
 * @package backend\modules\cms\controllers
 */
class PageController extends BaseController
{
    /**
     * @var bool
     */
    public $isMultiLang = true;
    public $isAutoTranslation = true;

    /**
     * 是否启用高并发
     * @var bool
     */
    protected $highConcurrency = true;

    /**
      * @var Page
      */
    public $modelClass = Page::class;

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

    protected function beforeEdit($id = null, $model = null)
    {
        !$model->catalog_id && $model->catalog_id = Yii::$app->request->get('catalog_id', 0);
    }

    public function actionEditCatalog()
    {
        $id = Yii::$app->request->get('id', null);

        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->catalog_id > 0) {
                    return $this->redirect(['edit', 'catalog_id' => $model->catalog_id]);
                }
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);

    }
}
