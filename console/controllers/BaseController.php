<?php

namespace console\controllers;

use Yii;
use yii\base\Controller;

/**
 * Class BaseController
 * @package console\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends Controller
{
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

        return true;
    }
}