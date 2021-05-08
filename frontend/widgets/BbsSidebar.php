<?php

namespace frontend\widgets;

use Yii;
use common\models\bbs\Topic;
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
        $excellent = Topic::find()->where(['store_id' => Yii::$app->storeSystem->getId()])->andWhere(['>', 'grade', 0])->orderBy(['sort' => SORT_ASC, 'created_at' => SORT_DESC])->limit(8)->all();
        return $this->render(Inflector::camel2id(StringHelper::basename(get_class($this))), [
            'type' => $this->type,
            //'model' => $model,
            'excellent' => $excellent,
        ]);
    }

}