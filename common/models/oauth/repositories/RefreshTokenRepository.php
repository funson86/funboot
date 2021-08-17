<?php

namespace common\models\oauth\repositories;

use common\models\oauth\entities\RefreshTokenEntity;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use Yii;

/**
 * Class RefreshTokenRepository
 * @package common\models\oauth\repositories
 * @author funson86 <funson86@gmail.com>
 */
class RefreshTokenRepository implements \League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }

    /**
     * @inheritDoc
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $time = $refreshTokenEntity->getExpiryDateTime();
        return Yii::$app->oauthSystem->refreshTokenCreate(
            $refreshTokenEntity->getAccessToken()->getClient()->getIdentifier(),
            $refreshTokenEntity->getIdentifier(),
            $refreshTokenEntity->getAccessToken()->getUserIdentifier(),
            $time->getTimestamp(),
            $refreshTokenEntity->getAccessToken()->getScopes(),
            $refreshTokenEntity->getAccessToken()->getClient()->getGrantType()
        );
    }

    /**
     * @inheritDoc
     */
    public function revokeRefreshToken($tokenId)
    {
        return Yii::$app->oauthSystem->refreshTokenDelete($tokenId);
    }

    /**
     * @inheritDoc
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        return empty(Yii::$app->oauthSystem->refreshTokenFindByAccessToken($tokenId));
    }
}
