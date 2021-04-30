<?php

namespace frontend\widgets;

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * Class BbsSidebar
 * @package frontend\widgets
 * @author funson86 <funson86@gmail.com>
 */
class BbsSidebar extends \yii\base\Widget
{
    public $type = 'node';
    public $nodeId = null;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render(Inflector::camel2id(StringHelper::basename(get_class($this))), [
            'type' => $this->type,
            //'model' => $model,
        ]);
    }

}