<?php

namespace console\controllers;

use common\models\base\Log;
use common\models\User;
use Yii;
use console\components\MysqlBackup;

/**
 * Class DbController
 * @package console\controllers
 * @author funson86 <funson86@gmail.com>
 */
class DbController extends BaseController
{
    /**
     * 备份所有数据表，生成sql
     * @return string
     */
    public function actionBackup()
    {
        $model = new MysqlBackup();
        if ($fileName = $model->execute()) {
            $msg = 'Database backup Success in ' . $fileName;
        } else {
            $msg = 'Database backup failed';
        }
        Yii::$app->logSystem->console(Yii::$app->controller->route, 200, $msg);
        return $msg;
    }

    public function actionDropForeignKey()
    {
        $sql = "

ALTER TABLE fb_school_student DROP FOREIGN KEY school_student_fk2;

        ";

        Yii::$app->db->createCommand($sql)->execute();

        Yii::$app->logSystem->console(Yii::$app->controller->route, 200, "Drop all table foreign key");
        return 'success';
    }

}
