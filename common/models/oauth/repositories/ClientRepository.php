<?php

namespace common\models\oauth\repositories;

use common\models\oauth\entities\ClientEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Yii;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class ClientRepository
 * @package common\models\oauth\repositories
 * @author funson86 <funson86@gmail.com>
 */
class ClientRepository implements \League\OAuth2\Server\Repositories\ClientRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getClientEntity($clientIdentifier)
    {
        if (!($client = Yii::$app->oauthSystem->findByClientId($clientIdentifier))) {
            throw new UnprocessableEntityHttpException(Yii::t('app', 'Invalid client'));
        }

        $entity = new ClientEntity();
        $entity->setIdentifier($clientIdentifier);
        $entity->setName($client['name']);
        $entity->setRedirectUri($client['redirect_uri']);
        $entity->setIsConfidential(true);

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        if (!($client = Yii::$app->oauthSystem->findByClientId($clientIdentifier))) {
            throw new UnprocessableEntityHttpException(Yii::t('app', 'Invalid client'));
        }
        if ($client['client_secret'] !== $clientSecret) {
            throw new UnprocessableEntityHttpException(Yii::t('app', 'Invalid client secret'));
        }

        $entity = new ClientEntity();
        $entity->setIdentifier($clientIdentifier);
        $entity->setName($client['name']);
        $entity->setGrantType($grantType);

        return true;
    }
}
