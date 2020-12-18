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
            if (is_array($response->data)) {
                $data = $response->data;
            } else {
                $data['data'] = $response->data;
            }

            !isset($data['code']) && $data['code'] = $response->statusCode;
            !isset($data['msg']) && $data['msg'] = ResultHelper::getMsg($data['code']);

            $response->content = Json::encode($data, $options);
        } elseif ($response->content === null) {
            $response->content = 'null';
        }
    }

}