<?php

namespace common\widgets\base;

use common\models\base\Stuff;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * Class BbsSidebar
 * @package frontend\widgets
 * @author funson86 <funson86@gmail.com>
 */
class StuffWidget extends \yii\base\Widget
{
    public $style = 1;

    public $codeId = null;
    public $position = null;
    public $type = null;
    public $limit = null;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $models = Stuff::getByCodeId($this->codeId, $this->position, $this->type, $this->limit);
        return $this->render(Inflector::camel2id(StringHelper::basename(get_class($this))), [
            'models' => $models,
            'style' => $this->style,
        ]);
    }

}