<?php

namespace api\modules\v21\models;

/**
 * Class User
 * @package api\models\food
 * @author funson86 <funson86@gmail.com>
 */
class User extends \api\models\User
{
    public function fields()
    {
        return [
            'id', 'access_token', 'refresh_token', 'username', 'email', 'store',
        ];
    }

    /**
     * 指定extraFields中显示哪些字段
     * @return \stdClass|\yii\db\ActiveQuery|null
     */
    public function getStore()
    {
        return parent::getStore() ? parent::getStore()->select(['id', 'name', 'host_name', 'expired_at']) : new \stdClass();
    }


}
