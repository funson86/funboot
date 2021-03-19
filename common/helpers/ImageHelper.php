<?php

namespace common\helpers;

use Yii;

/**
 * Class ImageHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class ImageHelper
{
    /**
     * 默认图片
     * @param string $path
     * @return bool|string
     */
    public static function get($path)
    {
        if (!$path) {
            return '';
        }
        if (strpos($path, '/') === 0) {
            return Yii::getAlias('@web' . $path);
        }

        return $path;
    }
    /**
     * 默认头像
     * @param string $path
     * @return bool|string
     */
    public static function getAvatar($path = null)
    {
        if (!$path) {
            $path = '/resources/images/default-avatar.png';
        }
        if (strpos($path, '/') === 0) {
            return Yii::getAlias('@web' . $path);
        }

        return $path;
    }

    /**
     * 默认头像
     * @param string $path
     * @return bool|string
     */
    public static function getLogo($path = null)
    {
        if (!$path) {
            $path = '/resources/images/default-logo.png';
        }
        if (strpos($path, '/') === 0) {
            return Yii::getAlias('@web' . $path);
        }

        return $path;
    }

    /**
     * 显示大图
     *
     * @param $image
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function fancyBox($image, $width = 45, $height = 45)
    {
        if (!$image) {
            $image = self::getAvatar();
        }

        $html = Html::img($image, [
            'width' => $width,
            'height' => $height,
        ]);

        return Html::a($html, $image, ['data-fancybox' => 'gallery']);
    }
}
