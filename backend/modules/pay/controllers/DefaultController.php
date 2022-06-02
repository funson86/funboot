<?php

namespace backend\modules\pay\controllers;

use backend\controllers\BaseController;
use common\models\pay\Payment;
use Yii;

/**
 * Default controller for the `pay` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMailAudit()
    {
        $id = Yii::$app->request->get('id');
        $type = Yii::$app->request->get('type');
        $createdAt = Yii::$app->request->get('created_at');
        $shipmentName = Yii::$app->request->get('shipment_name');

        if (!$id) {
            return $this->htmlFailed(404);
        }

        if ($type == 'payment') {
            $sn = Yii::$app->request->get('sn', null);

            $status = Yii::$app->request->get('status', null);
            if ($status) {
                $model = Payment::find()->where(['id' => $id, 'sn' => $sn, 'created_at' => $createdAt])->one();
                if (!$model || $model->store_id != $this->getStoreId()) {
                    return $this->htmlFailed(403);
                }

                if (!$status || !in_array(intval($status), array_keys(Payment::getStatusLabels()))) {
                    return $this->htmlFailed(422);
                }

                if (time() - $model->created_at > 3 * 3600) {
                    return $this->htmlFailed(429);
                }

                $model->status = intval($status);
                if (!$model->save()) {
                    return $this->htmlFailed();
                }
            }

            $storeStatus = Yii::$app->request->get('store_status', null);
            if (!is_null($storeStatus)) {
                $model = Payment::find()->where(['id' => $id, 'sn' => $sn, 'created_at' => $createdAt])->one();
                if (!$model || $model->store_id != $this->getStoreId()) {
                    return $this->htmlFailed(403);
                }

                $this->store->status = intval($storeStatus);
                if (!$this->store->save()) {
                    return $this->htmlFailed();
                }
            }

            return $this->htmlSuccess();
        }

    }
}
