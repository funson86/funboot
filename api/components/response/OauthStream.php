<?php

namespace api\components\response;
use Yii;
use yii\helpers\Json;

/**
 * Class OAuthStream
 * @package api\components\response
 * @author funson86 <funson86@gmail.com>
 */
class OauthStream implements \Psr\Http\Message\StreamInterface
{

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        // TODO: Implement close() method.
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        // TODO: Implement detach() method.
    }

    /**
     * @inheritDoc
     */
    public function getSize()
    {
        // TODO: Implement getSize() method.
    }

    /**
     * @inheritDoc
     */
    public function tell()
    {
        // TODO: Implement tell() method.
    }

    /**
     * @inheritDoc
     */
    public function eof()
    {
        // TODO: Implement eof() method.
    }

    /**
     * @inheritDoc
     */
    public function isSeekable()
    {
        // TODO: Implement isSeekable() method.
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        // TODO: Implement seek() method.
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    /**
     * @inheritDoc
     */
    public function isWritable()
    {
        // TODO: Implement isWritable() method.
    }

    /**
     * @inheritDoc
     */
    public function write($string)
    {
        Yii::$app->response->data = empty(json_decode($string)) ? $string : Json::decode($string);
    }

    /**
     * @inheritDoc
     */
    public function isReadable()
    {
        // TODO: Implement isReadable() method.
    }

    /**
     * @inheritDoc
     */
    public function read($length)
    {
        return strlen(Yii::$app->response->data);
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        return Yii::$app->response->data;
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
    }
}
