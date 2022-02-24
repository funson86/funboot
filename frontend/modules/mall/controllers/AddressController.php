<?php

namespace frontend\modules\mall\controllers;

use common\models\BaseModel;
use common\models\mall\Address;
use kartik\select2\Select2;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use Yii;

/**
 * Class AddressController
 * @package frontend\modules\mall\controllers
 * @author funson86 <funson86@gmail.com>
 */
class AddressController extends BaseController
{
    public $modelClass = Address::class;

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
        return $this->goHome();
    }

    public function actionEdit()
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirectSuccess(['/mall/user/address']);
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Address model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
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

        if (!$model->delete()) {
            return $this->redirectError();
        }

        return $this->redirectSuccess(['/mall/user/address']);
    }

}
