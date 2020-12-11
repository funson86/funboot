<?php

namespace common\helpers;

use Yii;
use yii\helpers\BaseUrl;

/**
 * Class Url
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class Url extends \yii\helpers\Url
{
    /**
     * 是否鉴权
     * @param string $url
     * @param bool $scheme
     * @param bool $check
     * @return string
     */
    public static function to($url = '', $scheme = false, $check = true)
    {
        $route = $url;
        if ($check) {
            if (is_array($route)) {
                $route[0] = self::normalizeRoute($route[0]);
                if (!Yii::$app->authSystem->verify('/' . $route[0])) {
                    return "javascript:fbWarning('" . Yii::t('app', 'No Auth') . "');";
                } else {
                    if ($scheme !== false) {
                        return parent::getUrlManager()->createAbsoluteUrl($route, is_string($scheme) ? $scheme : null);
                    }

                    return parent::getUrlManager()->createUrl($route);
                }
            } else {
                $url = Yii::getAlias($url);
                if ($url === '') {
                    $url = Yii::$app->getRequest()->getUrl();
                }

                if ($scheme === false) {
                    return $url;
                }

                if (static::isRelative($url)) {
                    // turn relative URL into absolute
                    $url = static::getUrlManager()->getHostInfo() . '/' . ltrim($url, '/');
                }

                return static::ensureScheme($url, $scheme);
            }
        } else {
            return parent::to($route, $scheme);
        }
    }
}
