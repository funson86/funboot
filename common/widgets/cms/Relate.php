<?php

namespace common\widgets\cms;

/**
 * Class Banner
 * @package common\widgets\cms
 * @author funson86 <funson86@gmail.com>
 */
class Relate extends \yii\base\Widget
{
    public $models;

    public function run()
    {
        return $this->render('relate', ['models' => $this->models]);
    }
}
