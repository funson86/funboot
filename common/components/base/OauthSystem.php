<?php

namespace common\components\base;

use common\helpers\CommonHelper;
use common\models\oauth\AccessToken;
use common\models\oauth\Client;
use common\models\oauth\RefreshToken;
use common\models\oauth\repositories\AccessTokenRepository;
use common\models\oauth\repositories\ClientRepository;
use common\models\oauth\repositories\ScopeRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use yii\base\Component;
use Yii;
use DateInterval;

/**
 * Class OauthSystem
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class OauthSystem extends Component
{
    /**
     * @var AuthorizationServer
     */
    protected $_server;

    public function getServer() : AuthorizationServer
    {
        return $this->_server;
    }

    public function setServer($grant)
    {
        $clientRepository = new ClientRepository();
        $scopeRepository = new ScopeRepository();
        $accessTokenRepository = new AccessTokenRepository();

        $this->_server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $this->getPrivateKey(),
            $this->getEncryptionKey()
        );

        $this->_server->enableGrantType($grant, new DateInterval(Yii::$app->params['oauth']['user']['accessTokenExpired'] ?? 'PT1H'));
    }

    public function getPrivateKey()
    {
        $path = Yii::$app->settingSystem->getValue('oauth_rsa_private') ?: Yii::$app->params['oauthRsaPrivate'];
        $privateKey = 'file://' . Yii::getAlias($path);
        if (Yii::$app->settingSystem->getValue('oauth_rsa_private_encryption')) {
            $key = new CryptKey($privateKey, Yii::$app->settingSystem->getValue('oauth_rsa_private_password'), !CommonHelper::isWin());
        } else {
            $key = new CryptKey($privateKey, null, !CommonHelper::isWin());
        }

        return $key;
    }

    public function getEncryptionKey()
    {
        return Yii::$app->settingSystem->getValue('oauth_encryption_key') ?? Yii::$app->params['oauth']['encryptionKey'];

    }

    /**
     * access
     * @param $clientId
     * @param $accessToken
     * @param $userId
     * @param $expiredAt
     * @param $scope
     * @param $grantType
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function accessTokenCreate($clientId, $accessToken, $userId, $expiredAt, $scope, $grantType)
    {
        $model = new AccessToken();
        $model->client_id = $clientId;
        $model->access_token = $accessToken;
        $model->user_id = $userId ?? 1;
        $model->expired_at = $expiredAt;
        $model->scope = $scope;
        $model->grant_type = $grantType ?? '';
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
        }

        return true;
    }

    public function accessTokenDelete($token)
    {
        AccessToken::deleteAll(['access_token' => $token]);
    }

    public function accessTokenFindByAccessToken($token, $clientId = null)
    {
        return AccessToken::find()->where(['access_token' => $token])->andFilterWhere(['client_id' => $clientId])->one();
    }

    public function accessTokenFindByClientId($clientId, $grantType)
    {
        return AccessToken::find()->where(['client_id' => $clientId])->andFilterWhere(['grant_type' => $grantType])->one();
    }

    /**
     * @param $clientId
     * @param $refreshToken
     * @param $userId
     * @param $expiredAt
     * @param $scope
     * @param $grantType
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function refreshTokenCreate($clientId, $refreshToken, $userId, $expiredAt, $scope, $grantType)
    {
        $model = new RefreshToken();
        $model->client_id = $clientId;
        $model->refresh_token = $refreshToken;
        $model->user_id = $userId ?? 1;
        $model->expired_at = $expiredAt;
        $model->scope = $scope;
        $model->grant_type = $grantType ?? '';
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
        }

        return true;
    }

    public function refreshTokenDelete($token)
    {
        RefreshToken::deleteAll(['refresh_token' => $token]);
    }

    public function refreshTokenFindByAccessToken($token, $clientId = null)
    {
        return RefreshToken::find()->where(['refresh_token' => $token])->andFilterWhere(['client_id' => $clientId])->one();
    }

    public function refreshTokenFindByClientId($clientId, $grantType)
    {
        return RefreshToken::find()->where(['client_id' => $clientId])->andFilterWhere(['grant_type' => $grantType])->one();
    }


    /**
     * @param $id
     * @param null $storeId
     * @return Client|null
     */
    public function findByClientId($id, $storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return Client::findOne(['client_id' => $id, 'status' => Client::STATUS_ACTIVE, 'store_id' => $storeId]);
    }
}
