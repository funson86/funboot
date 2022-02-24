<?php

namespace frontend\modules\mall\controllers;

use common\models\forms\ChangePasswordForm;
use common\models\mall\Address;
use common\models\mall\Cart;
use common\models\mall\Coupon;
use common\models\mall\Favorite;
use common\models\mall\Order;
use common\models\mall\Product;
use common\models\mall\ProductSku;
use common\models\ModelSearch;
use Yii;
use yii\filters\AccessControl;

/**
 * Class UserController
 * @package frontend\modules\mall\controllers
 * @author funson86 <funson86@gmail.com>
 */
class UserController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->goHome();
    }

    public function actionOrder()
    {
        $userId = Yii::$app->user->id;

        $searchModel = new ModelSearch([
            'model' => Order::class,
            'scenario' => 'default',
        ]);

        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['store_id'] = $this->getStoreId();
        $params['ModelSearch']['user_id'] = Yii::$app->user->id;
        $params['ModelSearch']['status'] = '>' . Order::STATUS_DELETED;
        $params['ModelSearch']['parent_id'] = 0;

        $dataProvider = $searchModel->search($params);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCoupon()
    {
        $searchModel = new ModelSearch([
            'model' => Coupon::class,
            'scenario' => 'default',
        ]);

        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['store_id'] = $this->getStoreId();
        $params['ModelSearch']['user_id'] = Yii::$app->user->id;
        $params['ModelSearch']['status'] = '>' . Coupon::STATUS_DELETED;
        $dataProvider = $searchModel->search($params);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionFavorite()
    {
        $searchModel = new ModelSearch([
            'model' => Favorite::class,
            'scenario' => 'default',
        ]);

        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['store_id'] = $this->getStoreId();
        $params['ModelSearch']['user_id'] = Yii::$app->user->id;
        $dataProvider = $searchModel->search($params);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionAddress()
    {
        $searchModel = new ModelSearch([
            'model' => Address::class,
            'scenario' => 'default',
        ]);

        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['store_id'] = $this->getStoreId();
        $params['ModelSearch']['user_id'] = Yii::$app->user->id;
        $params['ModelSearch']['status'] = '>' . Address::STATUS_DELETED;
        $dataProvider = $searchModel->search($params);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionSetting()
    {
        $user = Yii::$app->user->identity;
        $model = new ChangePasswordForm();

        if (Yii::$app->request->isPost) {
            if (Yii::$app->request->post()['User']) {
                $user->load(Yii::$app->request->post());
                if (!$user->save()) {
                    Yii::$app->logSystem->db($user->errors);
                    $this->flashError('error', Yii::t('app', 'Operation Failed'));
                } else {
                    $this->flashSuccess(Yii::t('app', 'Operate Successfully'));
                }
            } else {
                if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
                    Yii::$app->user->logout();
                    return $this->redirectSuccess(['/mall/default/login']);
                }
            }
        }

        return $this->render($this->action->id, [
            'user' => $user,
            'model' => $model,
        ]);
    }

}
