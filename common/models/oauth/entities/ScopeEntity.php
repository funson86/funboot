<?php

namespace common\models\oauth\entities;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

/**
 * Class ScopeEntity
 * @package common\models\oauth\entities
 * @author funson86 <funson86@gmail.com>
 */
class ScopeEntity implements \League\OAuth2\Server\Entities\ScopeEntityInterface
{
    use EntityTrait, ScopeTrait;

    public function jsonSerialize()
    {
        return $this->getIdentifier();
    }
}
