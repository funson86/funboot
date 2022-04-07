<?php

namespace backend\modules\base\controllers;

use common\models\forms\base\RechargeForm;
use Yii;
use common\models\base\Recharge;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;

/**
 * Recharge
 *
 * Class RechargeController
 * @package backend\modules\base\controllers
 */
class RechargeController extends BaseController
{
    /**
      * @var Recharge
      */
    public $modelClass = Recharge::class;

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

    public function actionNew()
    {
        $model = new RechargeForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($recharge = $model->build()) {
                    return $this->redirectSuccess(['pay', 'id' => $recharge->id]);
                } else {
                    Yii::$app->logSystem->db($model->errors);
                    $this->flashError($this->getError($model));
                }
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionPay()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }

        /** @var ActiveRecord $model */
        $model = $this->modelClass::findOne(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id, 'id' => $id]);
        if (!$model) {
            return $this->goBack();
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }
}
