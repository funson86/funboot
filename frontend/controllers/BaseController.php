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
        if (parent::beforeAction($action)) {
            // 前台强制为中文
            // Yii::$app->language = 'zh-CN';
            return true;
        }
        return false;
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
