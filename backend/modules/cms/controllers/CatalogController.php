<?php

namespace backend\modules\cms\controllers;

use common\models\base\Lang;
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
    /**
     * @var bool
     */
    public $isMultiLang = true;
    public $isAutoTranslation = true;

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

    protected function beforeEdit($id = null, $model = null)
    {
        $model->parent_id == 0 && $model->parent_id = Yii::$app->request->get('parent_id', 0);
        if (!$id) {
            $parent = $this->modelClass::findOne($model->parent_id);
            if ($parent) {
                $model->type = $parent->type;
                $model->kind = $parent->kind;
                $model->template = $parent->template;
                $model->template_page = $parent->template_page;
            }
        }
    }

    protected function beforeDeleteModel($id = null, $model = null, $soft = false, $tree = false)
    {
        if (!$soft) {
            Page::deleteAll(['catalog_id' => $id]);
        }
    }

    protected function clearCache()
    {
        return Yii::$app->cacheSystemCms->clearAllData($this->getStoreId());
    }
}
