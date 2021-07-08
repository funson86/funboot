<?php
namespace common\widgets\cms;

use Yii;

/**
 * Class Banner
 * @package common\widgets\cms
 * @author funson86 <funson86@gmail.com>
 */
class Portlet extends \yii\base\Widget
{
    public $root;
    public $portlet;
    public $page;

    public function run()
    {
        $catalogId = Yii::$app->request->get('id');
        if ($this->page) {
            $catalogId = $this->page->catalog->id ?? 0;
        }

        return $this->render('portlet', ['root' => $this->root, 'portlet' => $this->portlet, 'catalogId' => $catalogId]);
    }
}
