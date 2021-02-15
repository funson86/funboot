<?php

namespace common\widgets\cms;

/**
 * Class Banner
 * @package common\widgets\cms
 * @author funson86 <funson86@gmail.com>
 */
class Search extends \yii\base\Widget
{
    public function run()
    {
        return $this->render('search');
    }
}
