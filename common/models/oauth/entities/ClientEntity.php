<?php

namespace common\models\oauth\entities;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

/**
 * Class ClientEntity
 * @package common\models\oauth\entities
 * @author funson86 <funson86@gmail.com>
 */
class ClientEntity implements ClientEntityInterface
{
    use EntityTrait, ClientTrait;

    protected $grantType;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setRedirectUri($uri)
    {
        $this->redirectUri = $uri;
    }

    public function getGrantType()
    {
        return $this->grantType;
    }

    public function setGrantType($grantType)
    {
        $this->grantType = $grantType;
    }

    public function setIsConfidential($isConfidential)
    {
        $this->isConfidential = $isConfidential;
    }
}
