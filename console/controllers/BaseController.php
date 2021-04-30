<?php

namespace console\controllers;

use common\models\Store;
use Yii;
use yii\console\Controller;

/**
 * Class BaseController
 * @package console\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends Controller
{
    public $storeId = 2;

    public $store;

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        //不指定url，那么无法在邮件中使用Url::to 或者Yii::$app->urlManager->createAbsoluteUrl()函数
        Yii::$app->urlManager->setBaseUrl(Yii::$app->params['webBaseUrl']);
        Yii::$app->urlManager->setHostInfo(Yii::$app->params['webBaseUrl']);

        // 设置store
        $model = Store::findOne($this->storeId) ?? Store::findOne(Yii::$app->params['defaultStoreId']);
        $model->settings = Yii::$app->settingSystem->getSettings($model->id);
        $this->store = $model;
        Yii::$app->storeSystem->set($model);

        return true;
    }
}