<?php

namespace api\components\response;

use yii\base\Arrayable;
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

    /**
     * Serializes a model object.
     * @param Arrayable $model
     * @return array the array representation of the model
     */
    protected function serializeModel($model)
    {
        if ($this->request->getIsHead()) {
            return null;
        }

        list($fields, $expand) = $this->getRequestedFields();

        return [
            $this->collectionEnvelope => $model->toArray($fields, $expand),
        ];
    }

}