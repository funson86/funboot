<?php

namespace api\modules\v21\controllers;

use api\controllers\BaseController;
use api\modules\v21\models\Address;
use Yii;

/**
 * Class AddressController
 * @package api\modules\v21\controllers
 * @author funson86 <funson86@gmail.com>
 */
class AddressController extends BaseController
{
    public $modelClass = Address::class;

    public $optionalAuth = [];

    protected function filterParams(&$params)
    {
        $params['user_id'] = Yii::$app->user->id;
    }

    protected function beforeEdit($id = null, $model = null)
    {
        $model->user_id = Yii::$app->user->id;
    }

    public function actionViewDefault()
    {
        $model = Address::findOne(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id, 'is_default' => 1]);
        if (!$model) {
            $model = Address::find()->where(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->one();
        }
        return $model ?? new \stdClass();
    }
}
