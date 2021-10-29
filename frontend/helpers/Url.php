<?php

namespace frontend\helpers;

use Yii;

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
     * @param null $lang
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function to($url = '', $scheme = false, $lang = null)
    {
        !$lang && $lang = Yii::$app->request->get('lang');

        if ($lang) {
            if (is_array($url)) {
                $url['lang'] = $lang;
            } else {
                if (strpos($url, 'lang=') === false) {
                    $url = $url . (strpos($url, '?') === false ? '?' : '&') . 'lang=' . $lang;
                } else {
                    $url = self::attachLang($lang, Yii::$app->request->getUrl());
                }
            }
        }

        return parent::to($url, $scheme);
    }

    /**
     * 附加lang参数
     * @param null $lang
     * @param null $url
     * @param string $field
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function attachLang($lang = null, $url = null, $field = 'lang')
    {
        !$lang && $lang = Yii::$app->request->get($field);
        !$url && $url = Yii::$app->request->getUrl();

        $items = parse_url($url);
        $queries = [];
        if (isset($items['query'])) {
            $queryList = explode('&', $items['query']);
            foreach ($queryList as $q) {
                if (strpos($q, $field . '=') === false) {
                    array_push($queries, $q);
                }
            }
        }

        array_push($queries, $field . '=' . $lang);
        return $items['path'] . (isset($queries) ? '?' . implode('&', $queries) : '');
    }
}
