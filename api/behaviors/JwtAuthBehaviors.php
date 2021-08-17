<?php

namespace api\behaviors;

use api\components\response\OauthServerRequest;
use common\helpers\CommonHelper;
use common\models\oauth\repositories\AccessTokenRepository;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use yii\web\Controller;
use Yii;
use yii\web\UnauthorizedHttpException;

/**
 * Class JwtAuthBehaviors
 * @package api\behaviors
 * @author funson86 <funson86@gmail.com>
 */
class JwtAuthBehaviors extends \yii\base\Behavior
{
    public $optional = [];

    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    public function beforeAction($event)
    {
        if (in_array(Yii::$app->controller->action->id, $this->optional)) {
            return true;
        }

        $accessTokenRepository = new AccessTokenRepository();
        $path = Yii::$app->settingSystem->getValue('oauth_rsa_public') ?: Yii::$app->params['oauthRsaPublic'];
        $publicKeyPath = 'file://' . Yii::getAlias($path);
        $server = new ResourceServer($accessTokenRepository, new CryptKey($publicKeyPath, null, !CommonHelper::isWin()));

        try {
            $request = OauthServerRequest::fromGlobals();
            $server->validateAuthenticatedRequest($request);
        } catch (OAuthServerException $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        }

        $param = $request->getAttributes();
        if ($user = Yii::$app->oauthSystem->accessTokenFindByAccessToken($param['oauth_access_token_id'], $param['oauth_client_id'] ?? null)) {
            Yii::$app->user->login($user);
        } else {
            throw new UnauthorizedHttpException(Yii::t('app', 'Invalid ') . Yii::t('app', 'Token'));
        }

        return true;
    }
}
