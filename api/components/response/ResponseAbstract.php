<?php

namespace api\components\response;

Abstract class ResponseAbstract
{
    /**
     * @param int $code
     * @param null $msg
     * @param array $extra
     * @return mixed
     */
    abstract protected function error($code = 500, $msg = null, $data = []);

    /**
     * @param array $data
     * @param array $map
     * @param string $msg
     * @param int $code
     * @return mixed
     */
    abstract protected function success($data = [], $map = [], $msg = '', $code = 200);
}
