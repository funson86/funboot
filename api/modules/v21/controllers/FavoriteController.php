<?php

namespace api\modules\v21\controllers;

use api\modules\v21\models\Favorite;
use Yii;

/**
 * Class FavoriteController
 * @package api\modules\v21\controllers
 * @author funson86 <funson86@gmail.com>
 */
class FavoriteController extends \api\controllers\BaseController
{
    public $modelClass = Favorite::class;

    public $optionalAuth = [];

    protected function filterParams(&$params)
    {
        $params['user_id'] = Yii::$app->user->id;
    }
}
