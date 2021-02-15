<?php

namespace common\widgets\cms;

/**
 * Class Banner
 * @package common\widgets\cms
 * @author funson86 <funson86@gmail.com>
 */
class Portlet extends \yii\base\Widget
{
    public $portlet;

    public function run()
    {
        return $this->render('portlet', ['portlet' => $this->portlet]);
    }
}
