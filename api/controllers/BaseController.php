<?php

namespace api\controllers;

use Yii;
use yii\helpers\Json;

/**
 * Class BaseController
 * @package frontend\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends \common\components\controller\BaseController
{
    protected function error($code = 500, $msg = null, $data = [])
    {
        return Yii::$app->responseSystem->success($code = -1, $msg = null, $extra = []);
    }

    /**
     * @param $model
     * @return array
     */
    protected function commonData($model)
    {
        return [];
    }
}
