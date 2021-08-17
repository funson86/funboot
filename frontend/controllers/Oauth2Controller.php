<?php

namespace frontend\controllers;

use api\components\response\OauthResponse;
use api\components\response\OauthServerRequest;
use common\helpers\ResultHelper;
use common\models\LoginForm;
use common\models\oauth\entities\ScopeEntity;
use common\models\oauth\entities\UserEntity;
use common\models\oauth\repositories\AuthCodeRepository;
use common\models\oauth\repositories\RefreshTokenRepository;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ImplicitGrant;
use DateInterval;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Yii;
use yii\web\UnauthorizedHttpException;

/**
 * Class Oauth2Controller
 * @package frontend\controllers
 * @author funson86 <funson86@gmail.com>
 */
class Oauth2Controller extends BaseController
{
    public function actionAuthorizeCode()
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
            $authRequest = $server->validateAuthorizationRequest($request);
            Yii::$app->session->set('authRequest', serialize($authRequest));
        } catch (OAuthServerException $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        }

        if (!Yii::$app->user->isGuest) {
            return $this->callback();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->callback();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    protected function callback()
    {
        $server = Yii::$app->oauthSystem->getServer();
        $response = new OauthResponse();

        try {
            /** @var AuthorizationRequest $authRequest */
            $authRequest = unserialize(Yii::$app->session->get('authRequest'));
            $user = new UserEntity();
            $user->setIdentifier(Yii::$app->user->id);
            $authRequest->setUser($user);

            $scope = new ScopeEntity();
            $scope->setIdentifier('profile');
            $authRequest->setScopes([$scope]);

            $authRequest->setAuthorizationApproved(true);
            $server->completeAuthorizationRequest($authRequest, $response);

        } catch (OAuthServerException $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        }
    }

    /**
     * 简化模式
     * @return array
     * @throws \Exception
     */
    public function actionImplicit()
    {
        $grant = new ImplicitGrant(new DateInterval(Yii::$app->params['oauth']['user']['accessTokenExpired']));
        Yii::$app->oauthSystem->setServer($grant);
        $server = Yii::$app->oauthSystem->getServer();

        $response = new OauthResponse();
        $request = OauthServerRequest::fromGlobals();

        try {
            $authRequest = $server->validateAuthorizationRequest($request);
            $authRequest->setAuthorizationApproved(true);
            $authRequest->setUser(new UserEntity());
            $server->completeAuthorizationRequest($authRequest, $response);
        } catch (OAuthServerException $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        }
    }
}
