<?php

namespace backend\modules\mall\controllers;

use common\helpers\IdHelper;
use Yii;
use common\models\mall\CouponType;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * CouponType
 *
 * Class CouponTypeController
 * @package backend\modules\mall\controllers
 */
class CouponTypeController extends BaseController
{
    /**
      * @var CouponType
      */
    public $modelClass = CouponType::class;

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
        $model->startedTime = date('Y-m-d', ($model->started_at > 0 ? $model->started_at : time()));
        $model->endedTime = date('Y-m-d', ($model->ended_at > 0 ? $model->ended_at : time() + 3 * 86400));
    }

    protected function beforeEditSave($id = null, $model = null)
    {
        $post = Yii::$app->request->post();
        $model->started_at = strtotime($post['CouponType']['startedTime']);
        $model->ended_at = strtotime($post['CouponType']['endedTime']) + 86400 - 1;
        !$model->sn && $model->sn = substr(IdHelper::uuid(), -8);
        $model->type = strpos($model->money, '%') ? $this->modelClass::TYPE_PERCENT : $this->modelClass::TYPE_FIXED;

        return true;
    }

}
