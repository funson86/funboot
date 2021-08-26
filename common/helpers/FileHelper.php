<?php

namespace common\helpers;

use Yii;
use yii\helpers\Json;

/**
 * Class FileHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class FileHelper extends \yii\helpers\FileHelper
{
    public static function createFile($path, $name = null)
    {
        if (is_array($path)) {
            $path = implode(DIRECTORY_SEPARATOR, $path);
        }

        $path = Yii::getAlias($path);
        if (!$name) {
            $name = basename($path);
            $path = dirname($path);
        }

        if (!file_exists($path)) {
            self::createDirectory($path);
        }

        return $path . DIRECTORY_SEPARATOR . $name;
    }

    public static function writeLog($path, $content)
    {
        self::createFile($path);
        is_object($content) && $content = Json::encode(ArrayHelper::toArray($content));
        is_array($content) && $content = Json::encode($content);

        return file_put_contents($path, "\r\n" . $content, FILE_APPEND);
    }
}
