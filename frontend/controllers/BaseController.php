<?php

namespace frontend\controllers;

use common\helpers\IdHelper;
use yii\base\Model;
use common\models\Store;
use Yii;
use yii\helpers\Json;

/**
 * Class BaseController
 * @package frontend\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends \common\components\controller\BaseController
{
    public function beforeAction($action)
    {
        // 前台强制为英文
        if (parent::beforeAction($action)) {
            Yii::$app->language = 'en';
        }
        return true;
    }

    /**
     * @param $model
     * @return array
     */
    protected function commonData($model)
    {
        $settings = $this->getSettings();

        $commonData = [];

        return $commonData;
    }
}
