<?php

namespace api\modules\v21\controllers;

use api\modules\v21\models\Product;
use common\models\mall\Favorite;
use Yii;

/**
 * Class ProductController
 * @package api\modules\v21\controllers
 * @author funson86 <funson86@gmail.com>
 */
class ProductController extends \api\controllers\BaseController
{
    public $modelClass = Product::class;

    public $optionalAuth = ['index', 'view'];


    public function actionFavorite()
    {
        if (Yii::$app->request->post('product_id')) {
            $productId = Yii::$app->request->post('product_id');
            if (!$productId) {
                return $this->error(-11, Yii::t('mall', 'Need Product'));
            }
            $product = Product::findOne(['store_id' => $this->getStoreId(), 'id' => $productId]);
            if (!$product) {
                return $this->error(-11, Yii::t('mall', 'Need Product'));
            }

            $model = Favorite::find()->where(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id, 'product_id' => $productId])->one();
            if ($model) {
                $model->delete();
                return $this->success(0);
            } else {
                $model = new Favorite();
                $model->user_id = Yii::$app->user->id;
                $model->product_id = $productId;
                $model->name = $product->name;
                if (!$model->save()) {
                    Yii::$app->logSystem->db($model->errors);
                    return $this->success(0);
                }
                return $this->success(1);
            }
        } elseif (Yii::$app->request->get('product_id')) {
            $productId = Yii::$app->request->get('product_id');
            if (!$productId) {
                return $this->error(-11, Yii::t('mall', 'Need Product'));
            }
            $product = \common\models\mall\Product::findOne(['store_id' => $this->getStoreId(), 'id' => $productId]);
            if (!$product) {
                return $this->error(-11, Yii::t('mall', 'Need Product'));
            }

            $model = Favorite::find()->where(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id, 'product_id' => $productId])->one();
            if ($model) {
                return $this->success(1);
            }
            return $this->success(0);
        }

        return $this->error();
    }
}
