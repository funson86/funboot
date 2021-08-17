<?php

namespace api\components\response;

use Psr\Http\Message\StreamInterface;
use Yii;

/**
 * Class OAuthResponse
 * @package api\components\response
 * @author funson86 <funson86@gmail.com>
 */
class OauthResponse implements \Psr\Http\Message\ResponseInterface
{
    public $_stream;

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        return Yii::$app->response->version;
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        Yii::$app->response->version = $version;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return Yii::$app->response->headers;
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        return Yii::$app->response->headers->has($name);
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        return Yii::$app->response->headers->get($name);
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        Yii::$app->response->headers->set($name, $value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        Yii::$app->response->headers->set($name, $value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        Yii::$app->response->headers->remove($name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        if (!$this->_stream) {
            $this->_stream = new OauthStream();
        }
        return $this->_stream;
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        $this->_stream = $body;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return Yii::$app->response->statusCode;
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        Yii::$app->response->setStatusCode($code, $reasonPhrase);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        return Yii::$app->response->statusText;
    }
}
