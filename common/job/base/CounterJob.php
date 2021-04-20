<?php
namespace common\job\base;

use common\job\BaseJob;
use common\models\bbs\Topic;
use Yii;
use yii\base\Model;

/**
 * 计数器任务  如果使用缓存，需要同时更新缓存，如果是使用redis，使用计数器更新
 * Class CounterJob
 * @author funson86 <funson86@gmail.com>
 */
class CounterJob extends BaseJob
{
    public $modelClass;
    public $id;
    public $field = 'click';
    public $count = 1;

    public function execute($queue)
    {
        if (!parent::execute($queue)) {
            return false;
        }

        if (!is_subclass_of($this->modelClass, Model::class)) {
            return false;
        }

        $this->modelClass::updateAllCounters([$this->field => $this->count], ['id' => $this->id]);

        return true;
    }
}