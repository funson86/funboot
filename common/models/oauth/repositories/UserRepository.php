<?php

namespace common\models\oauth\repositories;

use common\models\oauth\entities\UserEntity;
use common\models\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use Yii;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class UserRepository
 * @package common\models\oauth\repositories
 * @author funson86 <funson86@gmail.com>
 */
class UserRepository implements \League\OAuth2\Server\Repositories\UserRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        if (!$user = User::findByUsername($username, Yii::$app->storeSystem->getId())) {
            throw new UnprocessableEntityHttpException(Yii::t('app', 'Invalid user'));
        }

        if (!$user->validatePassword($password)) {
            throw new UnprocessableEntityHttpException(Yii::t('app', 'Invalid user or Password'));
        }

        $entity = new UserEntity();
        $entity->setIdentifier($user->id);

        return $entity;
    }
}
