<?php

namespace api\modules\v21\models;

/**
 * Class Address
 * @package api\modules\v21\models
 * @author funson86 <funson86@gmail.com>
 */
class Address extends \common\models\mall\Address
{
    public function fields()
    {
        return [
            'id', 'store_id', 'user_id', 'name', 'first_name', 'last_name', 'country', 'province', 'province', 'city',
            'district', 'address', 'address2', 'postcode', 'mobile', 'email', 'is_default', 'created_at',
        ];
    }
}
