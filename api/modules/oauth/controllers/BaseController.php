<?php

namespace api\modules\oauth\controllers;

use api\behaviors\JwtAuthBehaviors;
use yii\filters\auth\CompositeAuth;
use yii\filters\Cors;

/**
 * Class BaseController
 * @package api\modules\oauth\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends \api\controllers\BaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
        ];

        $behaviors['corsFilter'] = ['class' => Cors::class];

        $behaviors['jwtAuth'] = [
            'class' => JwtAuthBehaviors::class,
            'optional' => $this->optionalAuth,
        ];

        return $behaviors;
    }
}
