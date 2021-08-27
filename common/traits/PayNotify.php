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
    /**
     * @param $config
     * @return bool
     */
    public function wechat($config)
    {
        $response = PaymentFactory::factory('WechatPay', $config)->notify();
        if ($response->isPaid()) {
            $data = $response->getRequestData();
            return $this->afterNotify($data, 'wechat');
        }
        return false;
    }

    /**
     * 支付宝回调
     * @param $config
     * @return bool
     */
    public function alipay($config)
    {
        $config['ali_public_key'] = $config['alipay_notification_cert_path'];

        /** @var \Omnipay\Alipay\Requests\AopCompletePurchaseRequest $request */
        $request = PaymentFactory::factory('Alipay', $config)->notify();

        try {
            /** @var \Omnipay\Alipay\Responses\AopCompletePurchaseResponse $response */
            $response = $request->send();
            if ($response->isPaid()) {
                $data = Yii::$app->request->post();
                return $this->afterNotify($data, 'alipay');
            }
            return false;
        } catch (\Exception $e) {
            $this->writeLog($e->getMessage(), 'error');
            return false;
        }
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
