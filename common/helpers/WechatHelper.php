<?php

namespace common\helpers;

/**
 * Class WechatHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class WechatHelper
{
    public static function success()
    {
        return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
    }

    public static function error()
    {
        return ArrayHelper::toXml(['return_code' => 'FAIL', 'return_msg' => 'OK']);
    }
}
