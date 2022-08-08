<?php

namespace api\modules\v21\controllers;

use api\controllers\BaseController;
use api\models\forms\LoginEmailForm;
use api\modules\v21\models\User;
use common\models\mall\Product;
use common\services\mall\ProductService;
use frontend\models\SignupEmailForm;
use Yii;

/**
 * Default controller for the `v21` module
 */
class DefaultController extends BaseController
{
    public $modelClass = '';
    public $skipModelClass = '*';

    public $optionalAuth = ['index', 'login', 'signup'];

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $conditions = ['store_id' => $this->getStoreId(), 'status' => Product::STATUS_ACTIVE];
        $fields = ['id', 'thumb', 'name', 'type', 'star', 'price'];
        $productsNew = Product::find()->where($conditions)->select($fields)->orderBy(['created_at' => SORT_DESC])->limit(4)->asArray()->all();
        $productsHot = Product::find()->where($conditions)->select($fields)->orderBy(['sales' => SORT_DESC])->limit(4)->asArray()->all();
        return $this->success([
            'productNew' => ProductService::convertList($productsNew),
            'productHot' => ProductService::convertList($productsHot),
        ]);
    }

    public function actionLogin()
    {
        $model = new LoginEmailForm();
        $model->attributes = Yii::$app->request->post();
        if ($model->validate()) {
            return Yii::$app->accessTokenSystem->getAccessToken($model->getUser());
        }

        return $this->error();
    }

    public function actionSignup()
    {
        $model = new SignupEmailForm();
        $model->attributes = Yii::$app->request->post();
        if ($model->validate() && $user = $model->signup()) {
            return Yii::$app->accessTokenSystem->getAccessToken(User::findOne($user->id));
        }

        return $this->error($model->getFirstError('email'));
    }

    public function actionLogout()
    {
        User::updateAll(['access_token' => '', 'refresh_token' => ''], ['id' => Yii::$app->user->id]);
        return Yii::$app->accessTokenSystem->disableAccessToken(Yii::$app->user->identity->access_token);
    }

    public function actionCheckAccess()
    {
        return $this->success(Yii::$app->user->identity);
    }
}
