<?php

namespace common\helpers;

use Yii;

/**
 * Class AuthHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class AuthHelper
{
    /**
     * 鉴权
     * @param $url
     * @param array $list
     * @return bool
     */
    public static function verify($url, $list = [])
    {
        $ignoreUrlList = Yii::$app->params['ignoreUrlList'];
        if (self::urlMath($url, $ignoreUrlList)) {
            return true;
        }

        if (!$list) {
            $list = isset(Yii::$app->params['myPermissions']) ? Yii::$app->params['myPermissions'] : null;
        }

        return self::urlMath($url, $list);
    }

    /**
     * 获取最后一个字符串是否为指定字符
     * @param $url
     * @param array $list
     * @return bool
     */
    public static function urlMath($url, $list = [])
    {
        $bMath = false;
        if (empty($list) || !$url) {
            return false;
        }

        foreach ($list as $str) {
            if (StringHelper::isEndOf($str)) {
                $real = substr($str, 0, -1);
                if (strpos($url, $real) !== false) {
                    $bMath = true;
                    break;
                }
            } else {
                if ($url == $str) {
                    $bMath = true;
                    break;
                }
            }
        }

        return $bMath;
    }
}