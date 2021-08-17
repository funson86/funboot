<?php

namespace api\components\response;

use GuzzleHttp\Psr7\LazyOpenStream;

/**
 * Class OAuthServerRequest
 * @package api\components\response
 * @author funson86 <funson86@gmail.com>
 */
class OauthServerRequest extends \GuzzleHttp\Psr7\ServerRequest
{
    private $attributes = [];

    public static function fromGlobals()
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $headers = getallheaders();
        $uri = self::getUriFromGlobals();
        $body = new LazyOpenStream('php://input', 'r+');
        $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/', '', $_SERVER['SERVER_PROTOCOL']) : '1.1';
        $serverRequest = new self($method, $uri, $headers, $body, $protocol, $_SERVER);

        return $serverRequest
            ->withCookieParams($_COOKIE)
            ->withQueryParams($_GET)
            ->withParsedBody($_POST)
            ->withUploadedFiles(self::normalizeFiles($_FILES));
    }

    public function withAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
