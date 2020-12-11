<?php

namespace common\components\uploader\driver;

use League\Flysystem\Adapter\Local;
use Yii;

/**
 * Class Local
 * @package common\components\uploader\driver
 * @author funson86 <funson86@gmail.com>
 */
class LocalDriver extends AbstractDriver
{

    protected function init()
    {
        $this->adapter = new Local(Yii::getAlias('@attachment'));
    }

    protected function getConfig()
    {
        return [
            'rootPath' => Yii::$app->uploaderSystem->rootPath,
        ];
    }
}