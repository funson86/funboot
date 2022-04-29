<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use Yii;
use common\models\base\Department;

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

    protected function beforeEdit($id = null, $model = null)
    {
        $model->parent_id == 0 && $model->parent_id = Yii::$app->request->get('parent_id', 0);
    }

    protected function beforeEditRender($id = null, $model = null)
    {
        $model->heads = explode('|', $model->head);
        $model->viceHeads = explode('|', $model->vice_head);
    }

    protected function beforeEditSave($id = null, $model = null)
    {
        $heads = Yii::$app->request->post($model->formName())['heads'] ?? [];
        if (is_array($heads) && count($heads) > 0) {
            $model->head = implode('|', $heads);
        }

        $viceHeads = Yii::$app->request->post($model->formName())['viceHeads'] ?? [];
        if (is_array($heads) && count($viceHeads) > 0) {
            $model->vice_head = implode('|', $viceHeads);
        }

        return true;
    }
}
