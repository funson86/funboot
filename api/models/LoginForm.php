<?php
namespace api\models;

use api\models\User;

/**
 * Class LoginForm
 * @author funson86 <funson86@gmail.com>
 */
class LoginForm extends \common\models\LoginForm
{
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}