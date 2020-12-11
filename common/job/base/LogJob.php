<?php
namespace common\job\base;

use common\job\BaseJob;
use Yii;

/**
 * Class LogJbo
 * @author funson86 <funson86@gmail.com>
 */
class LogJob extends BaseJob
{
    public $model;

    public function execute($queue)
    {
        if (!parent::execute($queue)) {
            return false;
        }

        Yii::$app->logSystem->insert($this->model);
    }
}