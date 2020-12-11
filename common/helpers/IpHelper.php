<?php

namespace common\helpers;

use Zhuzhichao\IpLocationZh\Ip;
use Yii;

/**
 * Class IpHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class IpHelper extends \yii\helpers\IpHelper
{
    /**
     * @param $ip
     * @param bool $long
     * @return string|null
     */
    public static function ip2Location($ip, $long = false)
    {
        if (!$ip || strlen($ip) < 7) {
            return '';
        }

        if (($ip == '127.0.0.1') || ($long && (long2ip($ip) == '127.0.0.1'))) {
            return Yii::t('app', 'Local');
        }

        if ($long) {
            $ip = long2ip($ip);
        }

        $arr = Ip::find($ip);
        $str = '';
        if (!empty($arr)) {
            $str .= isset($arr[0]) ? $arr[0] : '';
            $str .= isset($arr[1]) ? '.' . $arr[1] : '';
            $str .= isset($arr[2]) ? '.' . $arr[2] : '';
        }
        return $str;
    }
}