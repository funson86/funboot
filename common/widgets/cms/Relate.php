<?php

namespace common\widgets\cms;

use common\helpers\ArrayHelper;
use common\models\cms\Page;

/**
 * Class Relate
 * @package common\widgets\cms
 * @author funson86 <funson86@gmail.com>
 */
class Relate extends \yii\base\Widget
{
    public $allCatalog;
    public $catalogId;
    public $pageId;
    public $models;

    public function run()
    {
        $rootId = ArrayHelper::getRootId($this->catalogId, $this->allCatalog);
        $ids = ArrayHelper::getChildrenIds($rootId, $this->allCatalog);
        $this->models = Page::find()
            ->where(['status' => Page::STATUS_ACTIVE, 'catalog_id' => $ids,])
            ->andFilterWhere(['<>', 'id', $this->pageId])
            ->orderBy(['click' => SORT_DESC, 'id' => SORT_ASC])
            ->limit(5)
            ->all();
        return $this->render('relate', ['models' => $this->models]);
    }
}
