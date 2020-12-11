<?php

namespace api\components\response;

use Yii;

/**
 * For IView
 * Class ResponseIview
 * @package api\components\response
 * @author funson86 <funson86@gmail.com>
 */
class ResponseIview extends ResponseAbstract
{
    /**
     * @param int $code
     * @param null $msg
     * @param array $data
     * @return array|mixed
     */
    protected function error($code = 500, $msg = null, $data = [])
    {
        $error = Yii::$app->params['error'];

        if ($msg === null) {
            $msg = isset($error[$code]) ? $error[$code] : '';
        }

        return [
            'code' => $code,
            'status' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }

    protected function success($data = [], $map = [], $msg = '', $code = 200)
    {
        return [
            'code' => 200,
            'status' => 200,
            'data' => $data,
            'map' => $map,
        ];
    }
}
