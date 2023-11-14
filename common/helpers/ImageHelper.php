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
            $path = Yii::$app->params['defaultAvatar'] ?? '/resources/images/default-avatar.png';
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
            $path = Yii::$app->params['defaultWebsiteLogo'] ?? '/resources/images/default-logo.png';
        }
        if (strpos($path, '/') === 0) {
            return Yii::getAlias('@web' . $path);
        }

        return $path;
    }

    /**
     * 默认商品图
     * @param string $path
     * @return bool|string
     */
    public static function getProductImage($path = null)
    {
        if (!$path) {
            $path = Yii::$app->params['defaultProductImage'] ?? '/resources/images/default-product-image.png';
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

    /**
     * 获取全http或https路径
     * @param $url
     * @return string
     */
    public static function getFullUrl($url)
    {
        if (strpos($url, 'http') === 0) {
            return $url;
        }

        (strpos($url, '/') !== 0) && $url = '/' . $url;
        return CommonHelper::getStoreUrl() . $url;
    }
}
