<?php

namespace common\components\bbs;

/**
 * Class SourceAbstract
 * @package common\components\bbs
 * @author funson86 <funson86@gmail.com>
 */
abstract class SourceAbstract
{
    abstract public function grab($url);
}
