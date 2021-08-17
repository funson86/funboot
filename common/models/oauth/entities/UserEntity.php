<?php

namespace common\models\oauth\entities;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * Class UserEntity
 * @package common\models\oauth\entities
 * @author funson86 <funson86@gmail.com>
 */
class UserEntity implements UserEntityInterface
{
    use EntityTrait;
}
