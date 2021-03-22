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

    /**
     * 获取子节点，最多往下3级，默认3级
     * @param $id
     * @param int $level
     * @return array|mixed
     * @throws \Exception
     */
    public function actionViewAjaxChild($id, $level = 3)
    {
        $model = $this->findModel($id);
        if (!$model) {
            return $this->error();
        }

        $list = [];
        foreach ($model->children as $child2) {
            $item = $child2->attributes;

            if ($level >= 3 && isset($child2->children)) {
                $sub3 = [];
                foreach ($child2->children as $child3) {
                    $sub3[] = $child3->attributes;
                }
                $item['children'] = $sub3;
            }

            $list[] = $item;
        }

        return $this->success($list);
    }

}
