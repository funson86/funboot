<?php

namespace common\job;

use common\models\Store;
use common\models\User;
use Yii;
use Exception;

/**
 * Class BaseJob
 * @package common\job
 * @author funson86 <funson86@gmail.com>
 */
class BaseJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        try {
            Yii::$app->db->open();
            if (!Yii::$app->db->getIsActive()) {
                // 看看会不会抛出异常
                $user = User::findOne(1);
            }
        } catch (Exception $e){
            // 重新连接
            Yii::$app->db->close();
            Yii::$app->db->open();
        }

        return true;
    }
}