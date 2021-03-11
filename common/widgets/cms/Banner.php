<?php

namespace common\widgets\cms;

/**
 * Class Banner
 * @package common\widgets\cms
 * @author funson86 <funson86@gmail.com>
 */
class Banner extends \yii\base\Widget
{
    public $banner;

    public function run()
    {
        return $this->render('banner', ['banner' => $this->banner]);
    }
}
