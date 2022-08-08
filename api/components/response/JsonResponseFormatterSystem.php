<?php

namespace api\components\response;

use common\helpers\ResultHelper;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Class JsonResponseFormatterSystem
 * @package api\components\response
 * @author funson86 <funson86@gmail.com>
 */
class JsonResponseFormatterSystem extends \yii\web\JsonResponseFormatter
{
    /**
     * Formats response data in JSON format.
     * @param Response $response
     */
    protected function formatJson($response)
    {
        if ($response->data !== null) {
            $options = $this->encodeOptions;
            if ($this->prettyPrint) {
                $options |= JSON_PRETTY_PRINT;
            }
            // 拼接字段
            if (is_array($response->data)) {
                if (isset($response->data['data']['data'])) {
                    $data = $response->data;
                    unset($data['data']);
                    $data['data'] = $response->data['data']['data'];
                } elseif (isset($response->data['data'])) {
                    $data = $response->data;
                    unset($data['data']);
                    $data['data'] = $response->data['data'];
                } else {
                    $data['data'] = $response->data;
                }
            } else {
                $data['data'] = is_object($response->data) ? json_encode($response->data) : $response->data;
            }

            (!isset($data['code']) || !$data['code']) && $data['code'] = $response->statusCode;
            (!isset($data['msg']) || !$data['msg']) && ($data['msg'] = ($data['data']['message'] ?? ResultHelper::getMsg($data['code'])));
            (!isset($data['map']) || !$data['map']) && $data['map'] = new \stdClass();
            $data['timestamp'] = time();

            $response->content = Json::encode($data, $options);
        } elseif ($response->content === null) {
            $response->content = 'null';
        }
    }

}