<?php

namespace console\controllers;

use common\models\base\Log;

/**
 * Class DayController
 * @package console\controllers
 * @author funson86 <funson86@gmail.com>
 */
class DayController extends BaseController
{
    public function actionIndex()
    {
        echo 'every day';
    }


    /**
     * 删除2个月之前的日志，搭配console/sh/mysqlbackup.sh中备份日志使用
     * @throws \yii\db\Exception
     */
    public function actionClearLog()
    {
        Log::deleteAll(['<', 'created_at', time() - 60 * 86400]);
    }
}
