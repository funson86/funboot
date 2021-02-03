<?php

namespace common\helpers;

use Yii;

/**
 * Class FileHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class FileHelper extends \yii\helpers\FileHelper
{
    public static function createFile($path, $name)
    {
        if (is_array($path)) {
            $path = implode(DIRECTORY_SEPARATOR, $path);
        }

        $path = Yii::getAlias($path);
        if (!file_exists($path)) {
            self::createDirectory($path);
        }

        return $path . DIRECTORY_SEPARATOR . $name;
    }
}
