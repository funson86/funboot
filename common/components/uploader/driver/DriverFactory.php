<?php

namespace common\components\uploader\driver;

use Xxtime\Flysystem\Aliyun\OssAdapter;

/**
 * Class DriverFactory
 * @package common\components\uploader\driver
 * @author funson86 <funson86@gmail.com>
 */
class DriverFactory
{
    public static function local($config = [])
    {
        return new LocalDriver($config);
    }

    public static function oss($config = [])
    {
        return new OssAdapter($config);
    }

}