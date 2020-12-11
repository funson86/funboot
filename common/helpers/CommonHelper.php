<?php

namespace common\helpers;

use yii\helpers\HtmlPurifier;
use yii\web\View;
use Yii;

class CommonHelper
{
    /**
     * 获取分页跳转
     *
     * @return array
     */
    public static function getPageSkipUrl()
    {
        $defautlUrl = Yii::$app->request->getHostInfo() . Yii::$app->request->url;
        $urlArr = explode('?', $defautlUrl);
        $defautlUrl = $urlArr[0];
        $getQueryParam = urldecode($urlArr[1] ?? '');
        $getQueryParamArr = explode('&', $getQueryParam);

        // 查询字符串是否有page
        foreach ($getQueryParamArr as $key => $value) {
            if (StringHelper::strExists($value, 'page=')) {
                unset($getQueryParamArr[$key]);
            }

            if (StringHelper::strExists($value, 'page_size=')) {
                unset($getQueryParamArr[$key]);
            }
        }

        $connector = !empty($getQueryParamArr) ? '?' : '';
        $fullUrl = $defautlUrl . $connector;
        $pageConnector = '?';
        if (!empty($getQueryParamArr)) {
            $fullUrl .= implode('&', $getQueryParamArr);
            $pageConnector = '&';
        }

        return [HtmlPurifier::process($fullUrl), $pageConnector];
    }

    /*
     * 移动端判断
     * @return bool
     */
    public static function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientKeywords = [
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            ];
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientKeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    public static function isPad()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return strpos($_SERVER['HTTP_USER_AGENT'], 'ipad') !== false;
        }
        return false;
    }

    /**
     * @param $viewFile
     * @param array $params
     * @param null $context
     * @param null $layout
     * @return string
     */
    public static function render($viewFile, $params = [], $context = null, $layout = null)
    {
        $view = new View();
        $content = $view->renderFile($viewFile, $params, $context);

        if ($layout) {
            $content = $view->renderFile($layout, ['content' => $content], $context);
        }

        return $content;
    }

    public static function parseBrowserLanguage()
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return 'en';
        }

        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5); //取前5位,有可能en在前面
        if (preg_match("/zh/i", $lang)) {
            return "zh-CN";
        } else {
            return "en";
        }

    }
}