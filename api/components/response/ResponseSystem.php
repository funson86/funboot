<?php

namespace api\components\response;

use common\helpers\ResultHelper;
use Yii;

class ResponseSystem extends ResponseAbstract
{
    /**
     * @param int $code
     * @param null $msg
     * @param array $data
     * @return array|mixed
     */
    public function error($code = 500, $msg = null, $data = [])
    {
        return ResultHelper::ret($code, $msg, $data);
    }

    /**
     * @param array $data
     * @param array $map
     * @param string $msg
     * @param int $code
     * @return array|mixed
     */
    public function success($data = [], $map = [], $msg = '', $code = 200)
    {
        return ResultHelper::ret($code, $msg, $data, $map);
    }
}
