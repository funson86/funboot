<?php

namespace api\controllers;

use api\behaviors\JwtAuthBehaviors;
use api\components\response\OauthResponse;
use api\components\response\OauthServerRequest;
use common\helpers\ResultHelper;
use common\models\oauth\repositories\AuthCodeRepository;
use common\models\oauth\repositories\RefreshTokenRepository;
use common\models\oauth\repositories\UserRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\AbstractGrant;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use yii\filters\Cors;
use yii\rest\ActiveController;
use DateInterval;
use Yii;

/**
 * Class OAuthController
 * @package api\controllers
 * @author funson86 <funson86@gmail.com>
 */
class Oauth2Controller extends BaseController
{
    public $modelClass = '';

    public $skipModelClass = '*';

    public $optionalAuth = ['index', 'authorize', 'password', 'client-credentials', 'refresh-token'];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = ['class' => Cors::class];

        $behaviors['jwtAuth'] = [
            'class' => JwtAuthBehaviors::class,
            'optional' => $this->optionalAuth,
        ];

        return $behaviors;
    }

    public function actionAuthorize()
    {
        $authCodeRepository = new AuthCodeRepository();
        $refreshTokenRepository = new RefreshTokenRepository();

        $grant = new AuthCodeGrant($authCodeRepository, $refreshTokenRepository, new DateInterval(Yii::$app->params['oauth']['user']['codeExpired']));
        $grant->setRefreshTokenTTL(new DateInterval(Yii::$app->params['oauth']['user']['refreshTokenExpired']));
        Yii::$app->oauthSystem->setServer($grant);
        $server = Yii::$app->oauthSystem->getServer();

        $response = new OauthResponse();
        $request = OauthServerRequest::fromGlobals();

        try {
            $server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $e) {
            return ResultHelper::ret(422, $e->getMessage());
        } catch (\Exception $e) {
            return ResultHelper::ret(422, $e->getMessage());
        }
    }

    public function actionPassword()
    {
        $userRepository = new UserRepository();
        $refreshRepository = new RefreshTokenRepository();
        $grant = new PasswordGrant($userRepository, $refreshRepository);
        $grant->setRefreshTokenTTL(new DateInterval(Yii::$app->params['oauth']['user']['refreshTokenExpired']));
        Yii::$app->oauthSystem->setServer($grant);
        $server = Yii::$app->oauthSystem->getServer();

        $response = new OauthResponse();
        $request = OauthServerRequest::fromGlobals();

        try {
            $server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $e) {
            return ResultHelper::ret(422, $e->getMessage());
        } catch (\Exception $e) {
            return ResultHelper::ret(422, $e->getMessage());
        }
    }

    public function actionClientCredentials()
    {
        $grant = new ClientCredentialsGrant();
        Yii::$app->oauthSystem->setServer($grant);
        $server = Yii::$app->oauthSystem->getServer();

        $response = new OauthResponse();
        $request = OauthServerRequest::fromGlobals();

        try {
            $server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $e) {
            return ResultHelper::ret(422, $e->getMessage());
        } catch (\Exception $e) {
            return ResultHelper::ret(422, $e->getMessage());
        }
    }

    public function actionRefreshToken()
    {
        $refreshRepository = new RefreshTokenRepository();
        $grant = new RefreshTokenGrant($refreshRepository);
        $grant->setRefreshTokenTTL(new DateInterval(Yii::$app->params['oauth']['user']['refreshTokenExpired']));
        Yii::$app->oauthSystem->setServer($grant);
        $server = Yii::$app->oauthSystem->getServer();

        return $this->respond($server);
    }

    /**
     * @param AuthorizationServer $server
     * @return array
     */
    protected function respond($server)
    {
        $response = new OauthResponse();
        $request = OauthServerRequest::fromGlobals();

        try {
            $server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $e) {
            return ResultHelper::ret(422, $e->getMessage());
        } catch (\Exception $e) {
            return ResultHelper::ret(422, $e->getMessage());
        }
    }
}
