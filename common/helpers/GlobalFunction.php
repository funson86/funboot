<?php

use yii\web\Response;

if (!function_exists('env')) {

    function env($envName, $default = false)
    {
        $envName = getenv($envName);

        return $envName === false ? $default : $envName;
    }
}

if (!function_exists('app')) {
    /**
     * App或App的定义组件
     *
     * @param null $component Yii组件名称
     * @param bool $throwException 获取未定义组件是否报错
     * @return null|object|\yii\console\Application|\yii\web\Application
     * @throws \yii\base\InvalidConfigException
     */
    function app($component = null, $throwException = true)
    {
        if ($component === null) {
            return Yii::$app;
        }
        return Yii::$app->get($component, $throwException);
    }
}

if (!function_exists('t')) {
    /**
     * i18n 国际化
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    function t($category, $message, $params = [], $language = null)
    {
        return Yii::t($category, $message, $params, $language);
    }
}

if (!function_exists('fbt')) {
    /**
     * @param $tableCode
     * @param $targetId
     * @param $name
     * @param $target
     * @param bool $force
     * @return string
     */
    function fbt($tableCode, $targetId, $name, $target = null, $force = false)
    {
        !$target && $target = Yii::$app->language;
        return Yii::$app->cacheSystem->getLang($tableCode, $targetId, $name, $target, $force);
    }
}

if (!function_exists('user')) {
    /**
     * User组件或者(设置|返回)identity属性
     *
     * @param null|string $attribute idenity属性
     * @return \yii\web\User|string|array
     */
    function user($attribute = null)
    {
        if (!$attribute) {
            return Yii::$app->user;
        }
        if (Yii::$app->user->isGuest()) {
            return null;
        }
        return Yii::$app->user->identity->{$attribute};
    }
}

if (!function_exists('request')) {
    /**
     * Request组件或者通过Request组件获取GET值
     *
     * @param string $key
     * @param mixed $default
     * @return \yii\web\Request|string|array
     */
    function request($key = null, $default = null)
    {
        if ($key === null) {
            return Yii::$app->request;
        }
        return Yii::$app->request->get($key, $default);
    }
}

if (!function_exists('params')) {
    /**
     * params 组件或者通过 params 组件获取值
     * @param $key
     * @return mixed|\yii\web\Session
     */
    function params($key)
    {
        return Yii::$app->params[$key] ?? null;
    }
}

/**
 * @param $message
 * @param bool|true $debug
 */
function pr($message, $debug = true)
{
    echo '<pre>';
    print_r($message);
    echo '</pre>';
    if ($debug) {
        die;
    }
}

/**
 * @param $message
 * @param bool|true $debug
 */
function vd($message, $debug = true)
{
    var_dump($message);
    if ($debug) {
        die;
    }
}
