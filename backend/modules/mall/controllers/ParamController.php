<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Param;
use common\models\ModelSearch;

/**
 * Param
 *
 * Class ParamController
 * @package backend\modules\mall\controllers
 */
class ParamController extends BaseController
{
    /**
     * @var bool
     */
    public $isMultiLang = true;
    public $isAutoTranslation = true;

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
                $modelTemp = Param::find()->where(['store_id' => $this->getStoreId(), 'parent_id' => $model->id, 'name' => $sub['name'][$i]])->one();
                if (!$modelTemp) {
                    $modelTemp = new Param();
                    $modelTemp->parent_id = $model->id;
                    $modelTemp->name = $sub['name'][$i];
                }
                $modelTemp->brief = $sub['brief'][$i];
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
     * @return array|mixed
     * @throws \Exception
     */
    public function actionViewAjaxChild()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->error();
        }
        $level = Yii::$app->request->get('level', 3);

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
