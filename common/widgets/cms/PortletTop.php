<?php

namespace common\widgets\cms;

/**
 * Class Banner
 * @package common\widgets\cms
 * @author funson86 <funson86@gmail.com>
 */
class PortletTop extends \yii\base\Widget
{
    public $root;
    public $portlet;

    public function run()
    {
        return $this->render('portlet-top', ['root' => $this->root, 'portlet' => $this->portlet]);
    }
}
