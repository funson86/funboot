<?php

namespace api\modules\v21\controllers;

use api\modules\v21\models\Coupon;
use api\modules\v21\models\User;
use api\modules\v21\models\Favorite;
use api\modules\v21\models\Address;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * Class UserController
 * @package api\modules\v21\controllers
 * @author funson86 <funson86@gmail.com>
 */
class UserController extends \api\controllers\BaseController
{
    public $modelClass = User::class;

    public function actionCoupon()
    {
        $query = Coupon::find()
            ->where(['>', 'status', Coupon::STATUS_DELETED])
            ->andFilterWhere(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id])
            ->orderBy(['status' => SORT_DESC, 'id' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
                'validatePage' => false,
            ],
        ]);
    }

    public function actionFavorite()
    {
        $query = Favorite::find()
            ->where(['>', 'status', Favorite::STATUS_DELETED])
            ->andFilterWhere(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id])
            ->orderBy(['status' => SORT_DESC, 'id' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
                'validatePage' => false,
            ],
        ]);
    }

    public function actionAddress()
    {
        $query = Address::find()
            ->where(['>', 'status', Address::STATUS_DELETED])
            ->andFilterWhere(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id])
            ->orderBy(['status' => SORT_DESC, 'id' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
                'validatePage' => false,
            ],
        ]);
    }
}
