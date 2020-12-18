<?php

namespace api\components\response;

use yii\web\Link;

/**
 * Class Serializer
 * @package api\components\response
 * @author funson86 <funson86@gmail.com>
 */
class Serializer extends \yii\rest\Serializer
{
    protected function serializePagination($pagination)
    {
        return [
            $this->linksEnvelope => null,
            $this->metaEnvelope => [
                'totalCount' => $pagination->totalCount,
                'pageCount' => $pagination->getPageCount(),
                'currentPage' => $pagination->getPage() + 1,
                'perPage' => $pagination->getPageSize(),
            ],
        ];
    }
}