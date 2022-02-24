<?php

namespace common\helpers;

/**
 * Class UiHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class UiHelper
{
    /**
     * 渲染star
     * @param $star
     * @param string $full
     * @param string $empty
     * @param string $half
     * @param int $max
     * @return string
     */
    public static function renderStar($star, $full = '<i class="fa fa-star"></i> ', $empty = '<i class="fa fa-star-o"></i>', $half = '<i class="fa fa-star-half-o"></i>', $max = 5)
    {
        $count = floor($star);
        $hasHalf = $star > $count;
        $str = '';
        for ($i = 0; $i < $max; $i++) {
            if ($i < $count) {
                $str .= $full;
            } elseif ($hasHalf) {
                $str .= $half;
            } else {
                $str .= $empty;
            }
        }

        return $str;
    }
}
