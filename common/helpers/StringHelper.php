<?php

namespace common\helpers;

use Yii;
use yii\helpers\BaseStringHelper;
use Ramsey\Uuid\Uuid;

/**
 * Class StringHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class StringHelper extends BaseStringHelper
{

    /*
     * 获取最后一个字符串是否为指定字符
     */
    public static function isEndOf($str, $char = '*')
    {
        return substr($str, -1) === $char;
    }

    /**
     * 转换成unicode字符
     * @param $str
     * @return string
     */
    public static function unicodeEncode($str)
    {
        $str = iconv('UTF-8', 'UCS-2', $str);
        $len = strlen($str);
        $new = '';
        for ($i = 0; $i < $len - 1; $i = $i + 2)
        {
            $c = $str[$i];
            $c2 = $str[$i + 1];
            if (ord($c) > 0)
            {    // 两个字节的文字
                $new .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
            }
            else
            {
                $new .= $c2;
            }
        }
        return $new;
    }

    /**
     * 从unicode转换成utf8
     * @param $str
     * @return string
     */
    public static function unicodeDecode($str)
    {
        // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
        $new = '';
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
        preg_match_all($pattern, $str, $matches);
        if (!empty($matches))
        {
            for ($j = 0; $j < count($matches[0]); $j++)
            {
                $str = $matches[0][$j];
                if (strpos($str, '\\u') === 0) {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $c = chr($code).chr($code2);
                    $c = iconv('UCS-2', 'UTF-8', $c);
                    $new .= $c;
                } else {
                    $new .= ' ' . $str;
                }
            }
        }

        if (strlen($new) == 0) {
            $new = $str;
        }

        return $new;
    }

    /**
     * 字符串匹配替换
     *
     * @param string $search 查找的字符串
     * @param string $replace 替换的字符串
     * @param string $subject 字符串
     * @param null $count
     * @return mixed
     */
    public static function replace($search, $replace, $subject, &$count = null)
    {
        return str_replace($search, $replace, $subject, $count);
    }

    /**
     * 分析枚举类型配置值
     *
     * 格式 a:名称1,b:名称2
     *
     * @param $string
     * @return array
     */
    public static function parseAttr($string)
    {
        $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
        if (strpos($string, ':')) {
            $value = [];
            foreach ($array as $val) {
                list($k, $v) = explode(':', $val);
                $value[$k] = Yii::t('setting', $v);
            }
        } else {
            $value = $array;
        }

        return $value;
    }

    /**
     * 返回字符串在另一个字符串中第一次出现的位置
     *
     * @param $string
     * @param $find
     * @return bool
     * true | false
     */
    public static function strExists($string, $find)
    {
        return !(strpos($string, $find) === false);
    }

    /**
     * 获取字符串后面的字符串
     *
     * @param string $fileName 文件名
     * @param string $type 字符类型
     * @param int $length 长度
     * @return bool|string
     */
    public static function clipping($fileName, $type = '.', $length = 0)
    {
        return substr(strtolower(strrchr($fileName, $type)), $length);
    }

    /**
     * 多个空格合并成一个
     * @param $str
     * @param string $target
     * @return string|string[]|null
     */
    public static function mergeSpace($str)
    {
        return preg_replace("/\s(?=\s)/", "\\1", $str);
    }

    /**
     * 替换回车换行符
     * @param $str
     * @param string $target
     * @return mixed
     */
    public static function replaceCrlf($str, $target = ' ')
    {
        return str_replace(array("\r\n", "\r", "\n"), $target, $str);
    }

    /**
     * 加密邮箱
     * @param $str
     * @param string $secretChar
     * @return mixed
     */
    public static function secretEmail($str, $secretChar = '*')
    {
        $arr = explode('@', $str);
        if (!is_array($arr)) {
            return $str;
        }

        return substr($arr[0], 0, 3) . $secretChar . '@' . $secretChar. substr($arr[1], -8);
    }

    /**
     * 加密名称
     * @param $str
     * @param string $secretChar
     * @return mixed
     */
    public static function secretName($str, $secretChar = '*')
    {
        if (strpos($str, '@') !== false) {
            return self::secretEmail($str, $secretChar);
        }

        return substr($str, 0, 2) . '***' . substr($str, -2);
    }

    /**
     * 百分比转数值
     * @param $str
     * @param int $decimals
     * @return float|int|string
     */
    public static function strToNumberOfPercent($str, $decimals = 0)
    {
        return $decimals > 0 ? number_format(floatval($str) / 100, $decimals) : (floatval($str) / 100);
    }

    /**
     * 数值转百分比
     * @param $number
     * @param int $decimals
     * @return float|int|string
     */
    public static function percentToStr($number, $decimals = 0)
    {
        return ($decimals > 0 ? round($number * 100, 2) : $number * 100) . '%';
    }

    /**
     * 计算中文字符的Ord累加值
     * @param $str
     */
    public static function mbStringOrd($str)
    {
        $len = mb_strlen($str);
        $index = 0;
        for ($i = 0; $i < $len; $i++) {
            $index += mb_ord(mb_substr($str, $i));
        }

        return $index;
    }

    /**
     * 判断url文件是否存在
     * @param $url
     * @return string
     */
    public static function getAttachmentPath($url)
    {
        if (ValidHelper::isUrl($url)) {
            if (!ValidHelper::isUrl(Yii::getAlias('@attachmentUrl'))) {
                $prefix = Yii::$app->request->hostInfo . Yii::getAlias('@attachmentUrl');
                $url = str_replace($prefix, '', $url);
            } else {
                $url = str_replace(Yii::getAlias('@attachmentUrl'), '', $url);
            }
        } else {
            $url = str_replace(Yii::getAlias('@attachmentUrl'), '', $url);
        }

        return Yii::getAlias('@attachment') . $url;
    }

    /**
     * 判断url是否为相对路径
     * @param $url
     * @return bool
     */
    public static function urlFull($url)
    {
        return (strpos($url, 'http://') !== false) || (strpos($url, 'https://') !== false);
    }

    /**
     * 返回固定长度并用省略号
     * @param $str
     * @param int $length
     * @param string $replace
     * @return string
     */
    public static function fixLength($str, $length = 10, $replace = '...')
    {
        if ($length < 0) {
            return $str;
        }

        if (strlen($str) > $length) {
            return substr($str, 0, $length) . $replace;
        }

        return $str;
    }
}
