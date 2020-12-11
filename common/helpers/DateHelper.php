<?php

namespace common\helpers;

use Yii;

/**
 * Class DateHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class DateHelper
{
    /**
     * 今天时间戳
     *
     * @return array
     */
    public static function today()
    {
        $now = time();
        return [
            'start' => mktime(0, 0, 0, date('m', $now), date('d', $now), date('Y', $now)),
            'end' => mktime(0, 0, 0, date('m', $now), date('d', $now) + 1, date('Y', $now)) - 1,
        ];
    }

    /**
     * 昨天时间戳
     *
     * @return array
     */
    public static function yesterday()
    {
        $now = time();
        return [
            'start' => mktime(0, 0, 0, date('m', $now), date('d', $now) - 1, date('Y', $now)),
            'end' => mktime(0, 0, 0, date('m', $now), date('d', $now), date('Y', $now)) - 1,
        ];
    }

    /**
     * 本周时间戳，从周一开始到周日
     *
     * @return array
     */
    public static function thisWeek()
    {
        $now = time();
        $length = 0;
        // 星期天返回上星期，因为计算周是从星期一到星期天
        if (date('w', $now) == 0) {
            $length = 7;
        }

        return [
            'start' => mktime(0, 0, 0, date('m', $now), date('d', $now) - date('w', $now) + 1 - $length, date('Y', $now)),
            'end' => mktime(23, 59, 59, date('m', $now), date('d', $now) - date('w', $now) + 7 - $length, date('Y', $now)),
        ];
    }

    /**
     * 最近7天
     *
     * @return array
     */
    public static function last7Day()
    {
        $now = time();
        $start = $now - 7 * 24 * 60 * 60;

        return [
            'start' => mktime(0, 0, 0, date('m', $start), date('d', $start), date('Y', $start)),
            'end' => mktime(23, 59, 59, date('m', $now), date('d', $now), date('Y', $now)),
        ];
    }

    /**
     * 最近30天
     *
     * @return array
     */
    public static function last30Day()
    {
        $now = time();
        $start = $now - 30 * 24 * 60 * 60;

        return [
            'start' => mktime(0, 0, 0, date('m', $start), date('d', $start), date('Y', $start)),
            'end' => mktime(23, 59, 59, date('m', $now), date('d', $now), date('Y', $now)),
        ];
    }

    /**
     * 最近30天
     *
     * @return array
     */
    public static function last30Week()
    {
        $now = time();
        $length = 0;
        // 星期天返回上星期，因为计算周是从星期一到星期天
        if (date('w', $now) == 0) {
            $length = 7;
        }

        return [
            'start' => mktime(0, 0, 0, date('m', $now), date('d', $now) - date('w', $now) + 1 - $length, date('Y', $now)) - 30 * 7 * 86400,
            'end' => mktime(23, 59, 59, date('m', $now), date('d', $now) - date('w', $now) + 7 - $length, date('Y', $now)),
        ];
    }

    /**
     * 本月时间戳
     *
     * @return array
     */
    public static function thisMonth()
    {
        $now = time();
        return [
            'start' => mktime(0, 0, 0, date('m', $now), 1, date('Y', $now)),
            'end' => mktime(23, 59, 59, date('m', $now), date('t', $now), date('Y', $now)),
        ];
    }

    /**
     * 上月时间戳
     *
     * @return array
     */
    public static function lastMonth()
    {
        $now = time();
        $start = mktime(0, 0, 0, date('m', $now) - 1, 1, date('Y', $now));
        $end = mktime(23, 59, 59, date('m', $now) - 1, date('t', $now), date('Y', $now));

        if (date('m', $start) != date('m', $end)) {
            $end -= 60 * 60 * 24;
        }

        return [
            'start' => $start,
            'end' => $end,
        ];
    }

    /**
     * 几个月前时间戳
     *
     * @return array
     */
    public static function recentMonth($month)
    {
        $now = time();
        return [
            'start' => mktime(0, 0, 0, date('m', $now) - $month, 1, date('Y', $now)),
            'end' => mktime(23, 59, 59, date('m', $now) - $month, date('t', $now), date('Y', $now)),
        ];
    }

    /**
     * 某月时间戳
     * @param null $month
     * @param null $year
     * @return array
     */
    public static function aMonth($month = null, $year = null)
    {
        $month = $month ?? date('m');
        $year = $year ?? date('Y');
        $lastDay = date('t', strtotime($year . '-' . $month));

        return [
            "start" => strtotime($year . '-' . $month),
            "end" => mktime(23, 59, 59, $month, $lastDay, $year)
        ];
    }

    /**
     * 某年时间戳
     * @param $year
     * @return array
     */
    public static function aYear($year = null)
    {
        $year = $year ?? date('Y');
        $startTime = $year . '-01-01 00:00:00';
        $endTime = $year . '-12-31 23:59:59';

        return [
            'start' => strtotime($startTime),
            'end' => strtotime($endTime)
        ];
    }

    /**
     * 中文直接调用
     * 英文调用 getWeekName($timeStamp, true);
     * @param int $timeStamp
     * @param bool $en
     * @return string
     */
    public static function getWeekName(int $timeStamp = 0, $en = false)
    {
        $timeStamp = $timeStamp ?? time();

        $weekName = [
            Yii::t('app', 'SUN'),
            '一',
            '二',
            '三',
            '四',
            '五',
            '六'
        ];

        return $weekName[date('w', $timeStamp)];
    }

    /**
     * 将时间长度可读
     *
     * @param $time
     * @return string
     */
    public static function humanizeTime($time)
    {
        $min = $time / 60;
        $hours = $time / 3600;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));

        return $days . Yii::t('app', " 天 ") . $hours . Yii::t('app', " 小时 ") . $min . Yii::t('app', " 分钟 ");
    }

    /**
     * 时间戳精确到微秒
     *
     * @param integer $accuracy 精度 默认微妙
     * @return int
     */
    public static function microtime($accuracy = 1000)
    {
        list($msec, $sec) = explode(' ', microtime());
        $msecTime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * $accuracy);

        return $msecTime;
    }

    /**
     * 时间戳精确到微秒
     *
     * @param integer $accuracy 精度 默认微妙
     * @return int
     */
    public static function getCurrentMicrotime()
    {
        return floor(microtime(true) * 1000) | 0;
    }
}
