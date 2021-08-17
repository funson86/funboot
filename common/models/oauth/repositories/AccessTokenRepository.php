<?php

namespace common\models\oauth\repositories;

use common\models\oauth\entities\AccessTokenEntity;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use Yii;

/**
 * Class AccessTokenRepository
 * @package common\models\oauth\repositories
 * @author funson86 <funson86@gmail.com>
 */
class AccessTokenRepository implements \League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface
{

    /**
     * 创建新Token
     * @inheritDoc
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }

    /**
     * 存储新Token
     * @inheritDoc
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $time = $accessTokenEntity->getExpiryDateTime();
        return Yii::$app->oauthSystem->accessTokenCreate(
            $accessTokenEntity->getClient()->getIdentifier(),
            $accessTokenEntity->getIdentifier(),
            $accessTokenEntity->getUserIdentifier(),
            $time->getTimestamp(),
            $accessTokenEntity->getScopes(),
            $accessTokenEntity->getClient()->getGrantType()
        );
    }

    /**
     * 刷新Token时调用，原有的删除，创建新的
     * @inheritDoc
     */
    public function revokeAccessToken($tokenId)
    {
        return Yii::$app->oauthSystem->accessTokenDelete($tokenId);
    }

    /**
     * 验证Token是否已经删除
     * @inheritDoc
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return empty(Yii::$app->oauthSystem->accessTokenFindByAccessToken($tokenId));
    }
}
