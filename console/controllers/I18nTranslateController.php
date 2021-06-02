<?php

namespace console\controllers;

use common\helpers\BaiduTranslate;
use common\models\Store;
use Yii;
use common\models\base\Lang;

/**
 * Class I18nTranslateController
 * @package console\controllers
 * @author funson86 <funson86@gmail.com>
 */
class I18nTranslateController extends BaseController
{
    public function actionIndex()
    {
        $languageCodes = Lang::getLanguageCode();

        foreach ($languageCodes as $id => $code) {
            if (in_array($code, ['en', 'zh-CN'])) {
                continue;
            }

            $targetFile = dirname(dirname(__DIR__)) . "/common/messages/$code/app.php";
            if (file_exists($targetFile)) {
                $oldData = require $targetFile;
            }
            $str = "<?php\nreturn [\n";
            $data = require dirname(dirname(__DIR__)) . "/common/messages/zh-CN/app.php";
            foreach ($data as $source => $target) {
                if (isset($oldData[$source]) && strlen($oldData[$source]) > 0) {
                    $trans = $oldData[$source];
                } else {
                    /*if ($code != 'zh-HK') {
                        $trans = BaiduTranslate::translate($source, Lang::getLanguageBaiduCode($id), 'en');
                    } else {*/
                    $trans = BaiduTranslate::translate($target, Lang::getLanguageBaiduCode($id), 'zh');
                    //}
                }
                echo "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
                $str .= "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
            }
            $str .= "];\n";
            file_put_contents($targetFile, $str);


            $targetFile = dirname(dirname(__DIR__)) . "/common/messages/$code/permission.php";
            if (file_exists($targetFile)) {
                $oldData = require $targetFile;
            }
            $str = "<?php\nreturn [\n";
            $data = require dirname(dirname(__DIR__)) . "/common/messages/en/permission.php";
            foreach ($data as $source => $target) {
                if (isset($oldData[$source]) && strlen($oldData[$source]) > 0) {
                    $trans = $oldData[$source];
                } else {
                    if ($code == 'zh-HK') {
                        $trans = BaiduTranslate::translate($source, Lang::getLanguageBaiduCode($id), 'zh');
                    } else {
                        $trans = BaiduTranslate::translate($target, Lang::getLanguageBaiduCode($id), 'en');
                    }
                }
                echo "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
                $str .= "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
            }
            $str .= "];\n";
            file_put_contents($targetFile, $str);


            $targetFile = dirname(dirname(__DIR__)) . "/common/messages/$code/setting.php";
            if (file_exists($targetFile)) {
                $oldData = require $targetFile;
            }
            $str = "<?php\nreturn [\n";
            $data = require dirname(dirname(__DIR__)) . "/common/messages/en/setting.php";
            foreach ($data as $source => $target) {
                if (isset($oldData[$source]) && strlen($oldData[$source]) > 0) {
                    $trans = $oldData[$source];
                } else {
                    if ($code == 'zh-HK') {
                        $trans = BaiduTranslate::translate($source, Lang::getLanguageBaiduCode($id), 'zh');
                    } else {
                        $trans = BaiduTranslate::translate($target, Lang::getLanguageBaiduCode($id), 'en');
                    }
                }
                echo "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
                $str .= "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
            }
            $str .= "];\n";
            file_put_contents($targetFile, $str);


            $targetFile = dirname(dirname(__DIR__)) . "/common/messages/$code/cons.php";
            if (file_exists($targetFile)) {
                $oldData = require $targetFile;
            }
            if (!file_exists(dirname(dirname(__DIR__)) . "/common/messages/$code/cons.php")) {
                $str = "<?php\nreturn [\n";
                if ($code == 'zh-HK') {
                    $data = require dirname(dirname(__DIR__)) . "/common/messages/zh-CN/cons.php";
                } else {
                    $data = require dirname(dirname(__DIR__)) . "/common/messages/en/cons.php";
                }
                foreach ($data as $source => $target) {
                    if (isset($oldData[$source]) && strlen($oldData[$source]) > 0) {
                        $trans = $oldData[$source];
                    } else {
                        if (strpos($source, 'LANGUAGE_') !== false) {
                            $trans = $target;
                        } else {
                            if ($code == 'zh-HK') {
                                $trans = BaiduTranslate::translate($target, Lang::getLanguageBaiduCode($id), 'zh');
                            } else {
                                $trans = BaiduTranslate::translate($target, Lang::getLanguageBaiduCode($id), 'en');
                            }
                        }
                    }
                    echo "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
                    $str .= "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
                }
                $str .= "];\n";
                file_put_contents($targetFile, $str);
            }
        }
    }

    /**
     * 专门为cms，需要自行翻译中英文，其他语言翻译以英文为源语言
     * php yii i18n-translate/cms
     */
    public function actionCms()
    {
        $languageCodes = Lang::getLanguageCode();

        foreach ($languageCodes as $id => $code) {
            if (in_array($code, ['en', 'zh-CN'])) {
                continue;
            }

            $targetFile = dirname(dirname(__DIR__)) . "/common/messages/$code/cms.php";
            if (file_exists($targetFile)) {
                $oldData = require $targetFile;
            }
            $str = "<?php\nreturn [\n";
            $data = require dirname(dirname(__DIR__)) . "/common/messages/zh-CN/cms.php";
            foreach ($data as $source => $target) {
                if (isset($oldData[$source]) && strlen($oldData[$source]) > 0) {
                    $trans = $oldData[$source];
                } else {
                    if ($code != 'zh-HK') {
                        $trans = BaiduTranslate::translate($source, Lang::getLanguageBaiduCode($id), 'en');
                    } else {
                        $trans = BaiduTranslate::translate($target, Lang::getLanguageBaiduCode($id), 'zh');
                    }
                }
                echo "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
                $str .= "    '" . $source . "' => '" . str_replace("'", '\\\'', $trans) . "',\n";
            }
            $str .= "];\n";
            file_put_contents($targetFile, $str);

        }
    }
}