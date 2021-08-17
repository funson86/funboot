<?php

namespace common\models\oauth\repositories;

use common\models\oauth\entities\AuthCodeEntity;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

/**
 * Class AuthCodeRepository
 * @package common\models\oauth\repositories
 * @author funson86 <funson86@gmail.com>
 */
class AuthCodeRepository implements \League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }

    /**
     * @inheritDoc
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        // TODO: Implement persistNewAuthCode() method.
    }

    /**
     * @inheritDoc
     */
    public function revokeAuthCode($codeId)
    {
        // TODO: Implement revokeAuthCode() method.
    }

    /**
     * @inheritDoc
     */
    public function isAuthCodeRevoked($codeId)
    {
        // TODO: Implement isAuthCodeRevoked() method.
    }
}
