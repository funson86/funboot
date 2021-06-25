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
        $model->supportRoles = ArrayHelper::intToArray($model->support_role, $this->modelClass::getSupportRoleLabels());
    }

    protected function beforeEditSave($id = null, $model = null)
    {
        $post = Yii::$app->request->post();
        $model->support_role = ArrayHelper::arrayToInt($post['SettingType']['supportRoles']);
    }

    protected function afterEdit($id = null, $model = null)
    {
        Yii::$app->cacheSystem->clearAllSetting(); // 清理缓存
    }

    protected function afterDeleteModel($id, $soft = false, $tree = false)
    {
        Yii::$app->cacheSystem->clearAllSetting(); // 清理缓存
    }
}
