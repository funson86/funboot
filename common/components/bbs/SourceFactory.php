<?php

namespace common\components\bbs;

/**
 * Class SourceFactory
 * @package common\components\bbs
 * @author funson86 <funson86@gmail.com>
 */
class SourceFactory
{
    public static function create($class)
    {
        $class = dirname(__CLASS__) . '\\' . $class;
        return new $class;
    }
}