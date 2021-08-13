<?php

namespace console\modules\chat\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Class Log
 * @package console\modules\chat\models
 * @author funson86 <funson86@gmail.com>
 */
class Log extends \common\models\chat\Log
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
}
