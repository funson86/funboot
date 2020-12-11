<?php
namespace api\modules\v1\models;

/**
 * User Model
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class User extends \common\models\User
{
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

}
