<?php

namespace common\models\oauth\repositories;

use common\models\oauth\entities\ScopeEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Class ScopeRepository
 * @package common\models\oauth\repositories
 * @author funson86 <funson86@gmail.com>
 */
class ScopeRepository implements \League\OAuth2\Server\Repositories\ScopeRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        $scope = new ScopeEntity();
        $scope->setIdentifier($identifier);
        return $scope;
    }

    /**
     * @inheritDoc
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
    {
        return $scopes;
    }
}
