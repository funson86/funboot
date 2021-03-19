<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Param;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Param
 *
 * Class ParamController
 * @package backend\modules\mall\controllers
 */
class ParamController extends BaseController
{
    public $style = 11;

    /**
      * @var Param
      */
    public $modelClass = Param::class;

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

    protected function afterEdit($id = null, $model = null)
    {
        $post = Yii::$app->request->post();
        if (isset($post['Sub']) && is_array($post['Sub']) && count($post['Sub']) > 0) {
            Param::updateAll(['status' => Param::STATUS_DELETED], ['store_id' => $this->getStoreId(), 'parent_id' => $id]);

            $sub = $post['Sub'];
            $length = isset($sub['sort']) ? count($sub['sort']) : 0;
            if ($length <= 0) {
                return;
            }
            for ($i = 0; $i < $length; $i++) {
                $modelTemp = Param::find()->where(['store_id' => $this->getStoreId(), 'parent_id' => $id, 'name' => $sub['name'][$i]])->one();
                if (!$modelTemp) {
                    $modelTemp = new Param();
                    $modelTemp->store_id = $this->getStoreId();
                    $modelTemp->parent_id = $id;
                    $modelTemp->name = $sub['name'][$i];
                }
                $modelTemp->description = $sub['description'][$i];
                $modelTemp->sort = $sub['sort'][$i];
                $modelTemp->status = Param::STATUS_ACTIVE;
                if (!$modelTemp->save()) {
                    Yii::$app->logSystem->db($modelTemp->errors);
                }
            }

            Param::deleteAll(['status' => Param::STATUS_DELETED, 'store_id' => $this->getStoreId(), 'parent_id' => $id]);
        }
    }
}
