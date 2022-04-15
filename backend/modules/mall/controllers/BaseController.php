<?php

namespace backend\modules\mall\controllers;

use Yii;

/**
 * Class BaseController
 * @package backend\modules\mall\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends \backend\controllers\BaseController
{
    protected function clearCache()
    {
        return Yii::$app->cacheSystemMall->clearMallAllData($this->getStoreId());
    }
}
