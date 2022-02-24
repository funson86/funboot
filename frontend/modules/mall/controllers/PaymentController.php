<?php

namespace frontend\modules\mall\controllers;

use common\models\BaseModel;
use common\models\mall\Order;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use Yii;

/**
 * Class PaymentController
 * @package frontend\modules\mall\controllers
 * @author funson86 <funson86@gmail.com>
 */
class PaymentController extends BaseController
{
    public $modelClass = Order::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }
        /** @var Order $model */
        $model = $this->modelClass::findOne(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id, 'id' => $id]);
        if (!$model) {
            return $this->goBack();
        }

        if ($model->payment_method == Order::PAYMENT_METHOD_COD) {
            return $this->redirect(['/mall/payment/succeeded', 'id' => $id]);
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionSucceeded()
    {
        $id = Yii::$app->request->get('id', Yii::$app->request->post('id'));
        if (!$id) {
            return $this->goBack();
        }
        /** @var Order $model */
        $model = $this->modelClass::findOne(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id, 'id' => $id]);
        if (!$model) {
            return $this->goBack();
        }

        if (Yii::$app->request->isPost) {
            $model->payment_status = $model->status = Order::PAYMENT_STATUS_PAID;
            if (!$model->save()) {
                Yii::$app->logSystem->db($model->errors);
                return $this->error();
            }
            return $this->success();
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionCancelled()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }
        /** @var Order $model */
        $model = $this->modelClass::findOne(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id, 'id' => $id]);
        if (!$model) {
            return $this->goBack();
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionPay()
    {
        
    }
}
