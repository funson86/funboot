<?php
/**
 * Http Helper
 */
namespace common\helpers;

use Yii;

class HttpHelper
{
    public static function addHttp($str, $httpPrefix = null)
    {
        if (!$str) {
            return $str;
        }

        if (!$httpPrefix) {
            $httpPrefix = Yii::$app->params['httpPrefix'];
        }

        if (strpos($str, 'http') === 0) {
            return $str;
        }

        return $httpPrefix . $str;
    }

    /**
     *
     * 如果不是网络地址，加上服务器图片地址前缀
     * @param string $url
     * @param array $data
     * @param array $header $header = ['Content-Type: application/json', 'access_token:token'];
     * @param integer $timeout
     * @return string
     */
    public static function call($url, $data = null, $header = null, $timeout = 30)
    {
        if (!strstr($url, 'http://') && !strstr($url, 'https://')) {
            $url = 'http://' . $url;
        }

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        if (!empty($header)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($curl, CURLOPT_POST, false);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36');

        //执行
        $result = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($http_code == 200) {
            return $result;
        }

        if (curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
            return false;
        }

        curl_close($curl);

        return false;
    }

    public static function getGeoCoder($latitude, $longitude, $key = null)
    {
        !$key && $key = Yii::$app->params['mapQqKey'];
        $url = 'https://apis.map.qq.com/ws/geocoder/v1/?location=%s,%s&key=%s';
        $url = sprintf($url, $latitude, $longitude, $key);
        $result = self::call($url);
        if ($result) {
            $resultObj = json_decode($result);
            if ($resultObj->status == 0) {
                return $result;
            }
        }
        return $result;
    }

    /*
     * 发起POST网络提交
     * @params string $url : 网络地址
     * @params json $data ： 发送的json格式数据
     */
    public static function httpsPost($url,$data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /*
     * 发起GET网络提交
     * @params string $url : 网络地址
     */
    public static function httpsGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE) ;
        curl_setopt($curl, CURLOPT_TIMEOUT,60);
        if (curl_errno($curl)) {
            return 'Errno'.curl_error($curl);
        } else {
            $result=curl_exec($curl);
        }
        curl_close($curl);
        return $result;
    }
}
