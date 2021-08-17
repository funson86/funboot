<?php

namespace common\models\oauth\entities;

use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * Class AccessTokenEntity
 * @package common\models\oauth\entities
 * @author funson86 <funson86@gmail.com>
 */
class AccessTokenEntity implements \League\OAuth2\Server\Entities\AccessTokenEntityInterface
{
    use AccessTokenTrait, TokenEntityTrait, EntityTrait;
}
