<?php

namespace common\helpers;

use Yii;

class BaiduTranslate
{
    public static $url = 'http://api.fanyi.baidu.com/api/trans/vip/translate';
    public static $appId = '';
    public static $appSecret = '';

    public static $mapI18nCode = [
        'en' => 'en',
        'zh_CN' => 'zh',
    ];

    public static function init($appId = null, $appSecret = null, $url = null)
    {
        self::$appId = $appId ?? Yii::$app->params['baiduTranslate']['appId'];
        self::$appSecret = $appSecret ?? Yii::$app->params['baiduTranslate']['appSecret'];
        self::$url = $url ?? Yii::$app->params['baiduTranslate']['url'];
    }

    /**
     * @param $query
     * @param $to
     * @param string $from
     * @return string
     */
    public static function translate($query, $to = 'en', $from = 'auto') : string
    {
        self::init();

        $params = [
            'q' => $query,
            'appid' => self::$appId,
            'salt' => time(),
            'from' => self::$mapI18nCode[$from] ?? $from,
            'to' => self::$mapI18nCode[$to] ?? $to,
        ];

        $params['sign'] = md5(self::$appId . $query . $params['salt'] . self::$appSecret);

        $result = HttpHelper::call(self::$url, $params);

        $ret = json_decode($result, true);

        if (isset($ret['error_code'])) {
            Yii::$app->logSystem->db($ret['error_code'] . $ret['error_msg'] . ' ' . $query);
            return '';
        }

        return $ret['trans_result'][0]['dst'] ?? '';
    }
}
