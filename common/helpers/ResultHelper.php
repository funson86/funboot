<?php

namespace common\helpers;

use Yii;
use yii\web\Response;

/**
 * Class ResultHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class ResultHelper
{
    /**
     * response with error code which defined in /common/config/params.php
     *
     * @param  integer $code
     * @param  string $msg
     * @param  array $data
     * @param  array $map for pageSize pageNo count etc
     * @return array
     */
    public static function ret($code, $msg = null, $data = [], $map = [])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$msg) {
            $errorCode = Yii::$app->params['errorCode'];
            $msg = isset($errorCode[$code]) ? Yii::t('app', $errorCode[$code]) : '';
        }

        return [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'map' => $map,
        ];
    }

    /**
     * response with error code which defined in /config/error.php
     * @param array $config
     * @return array|string
     */
    public static function render($config = [])
    {
        $file = $config['file'] ?? Yii::getAlias(Yii::$app->params['htmlReturnFile']);

        $config['code'] = $config['code'] ?? 'success';
        $config['title'] = $config['code'] == 'success' ? Yii::t('app', 'Operate Successfully') : Yii::t('app', 'Operation Failed');

        if (is_int($config['msg'])) {
            $errorCode = Yii::$app->params['errorCode'];
            $config['msg'] = isset($errorCode[$config['msg']]) ? Yii::t('app', $errorCode[$config['msg']]) : $config['msg'];
        }

        return CommonHelper::render($file, ['config' => $config]);
    }
}
