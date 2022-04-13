<?php

namespace backend\modules\base\controllers;

use common\models\Store;
use Yii;
use common\models\base\Invoice;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Invoice
 *
 * Class InvoiceController
 * @package backend\modules\base\controllers
 */
class InvoiceController extends BaseController
{
    /**
      * @var Invoice
      */
    public $modelClass = Invoice::class;

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
     * @param null $id
     * @param Invoice $model
     * @return bool|void
     */
    protected function beforeEditRender($id = null, $model = null)
    {
        $model->amount = $this->getStore(true)->billable_fund;
    }

    /**
     * @param null $id
     * @param Invoice $model
     * @return bool|void
     */
    protected function beforeEditSave($id = null, $model = null)
    {
        if (is_null($id) && $model->amount <= 0) {
            $this->flashError(Yii::t('app', 'Amount must be greater than 0'));
            return false;
        }
        $model->user_id = Yii::$app->user->id;
        return true;
    }

    protected function afterEdit($id = null, $model = null)
    {
        if (is_null($id)) {
            Store::updateAllCounters(['billable_fund' => -$model->amount], ['id' => $model->store_id]);
        }
        Yii::$app->cacheSystem->refreshStoreById();
        $this->flashSuccess(Yii::t('app', 'Invoice is applied successfully, Please wait us to conduct it in 5 days'));
    }

    protected function beforeDeleteModel($id = null, $model = null, $soft = false, $tree = false)
    {
        Store::updateAllCounters(['billable_fund' => $model->amount], ['id' => $model->store_id]);
        Yii::$app->cacheSystem->refreshStoreById();
    }
}
