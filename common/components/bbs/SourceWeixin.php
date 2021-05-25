<?php

namespace common\components\bbs;

use common\helpers\CurlHelper;
use KubAT\PhpSimple\HtmlDomParser;

/**
 * Class SourceWeixin
 * @package common\components\bbs
 * @author funson86 <funson86@gmail.com>
 */
class SourceWeixin extends SourceAbstract
{
    public function grab($url)
    {
        $str = CurlHelper::getUrl($url, '');
        if (!$str) {
            return ['name' => null, 'content' => null];
        }
        $dom = HtmlDomParser::str_get_html($str);
        $name = $dom->find('.rich_media_title', 0) ? $dom->find('.rich_media_title', 0)->plaintext : '';
        $content = $dom->find('.rich_media_content', 0) ? $dom->find('.rich_media_content', 0)->innertext : '';
        strlen($content) > 5 && $content = CurlHelper::conductImage($content);
        $content = str_replace('data-src', 'src', $content);

        return [$name, $content];
    }
}