<?php

namespace backend\modules\tool;

!YII_ENV_DEV && die(\Yii::t('app', 'Show'));

/**
 * tool module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\tool\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
