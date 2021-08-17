<?php

namespace common\models\oauth\entities;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

/**
 * Class RefreshTokenEntity
 * @package common\models\oauth\entities
 * @author funson86 <funson86@gmail.com>
 */
class RefreshTokenEntity implements \League\OAuth2\Server\Entities\RefreshTokenEntityInterface
{
    use RefreshTokenTrait, EntityTrait;
}
