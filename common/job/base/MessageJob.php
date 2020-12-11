<?php
namespace common\job\base;

use common\job\BaseJob;
use Yii;

/**
 * Class MessageJob
 * @author funson86 <funson86@gmail.com>
 */
class MessageJob extends BaseJob
{
    public $model;

    public function execute($queue)
    {
        if (!parent::execute($queue)) {
            return false;
        }

        Yii::$app->messageSystem->insert($this->model);
    }
}