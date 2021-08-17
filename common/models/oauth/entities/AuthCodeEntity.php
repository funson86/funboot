<?php

namespace common\models\oauth\entities;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * Class AuthCodeEntity
 * @package common\models\oauth\entities
 * @author funson86 <funson86@gmail.com>
 */
class AuthCodeEntity implements \League\OAuth2\Server\Entities\AuthCodeEntityInterface
{
    use EntityTrait, TokenEntityTrait, AuthCodeTrait;
}
