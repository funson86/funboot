<?php

namespace common\traits;

use common\components\payment\PaymentFactory;
use common\helpers\FileHelper;
use Yii;

/**
 * Class PayNotify
 * @package common\traits
 * @author funson86 <funson86@gmail.com>
 */
trait PayNotify
{
    public function wechat($config)
    {
        $response = PaymentFactory::factory('Wechat', $config)->notify();
        if ($response->isPaid()) {
            $data = $response->getRequestData();
            return $this->afterNotify($data, 'wechat');
        }
        return false;
    }

    public function afterNotify($data = null, $type = null)
    {
        $this->writeLog($data, $type);
        return true;
    }

    public function writeLog($content = null, $type = null)
    {
        if (!$content) {
            return false;
        }

        !$type && $type = 'error';
        $path = Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR . 'payment' . DIRECTORY_SEPARATOR . date('Ym') . DIRECTORY_SEPARATOR . $type . '_' .date('d') . '.log';
        return FileHelper::writeLog($path, $content);
    }
}
