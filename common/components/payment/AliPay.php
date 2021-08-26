<?php

namespace common\components\payment;

use Omnipay\Omnipay;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WechatPayment
 * @package common\components\payment
 * @author funson86 <funson86@gmail.com>
 */
class AliPay extends BasePayment
{
    const TYPE_PC = 'Alipay_AopPage';
    const TYPE_APP = 'Alipay_AopApp';
    const TYPE_F2F = 'Alipay_AopF2F';
    const TYPE_WAP = 'Alipay_AopWap';

    public $config;

    public function initConfig($config)
    {
        $this->config = ArrayHelper::merge([
            'app_id' => $config['pay_alipay_appid'],
            'notify_url' => '',
            'return_url' => '',
            'ali_public_key' => $config['pay_alipay_cert_path'],
            // 加密方式： ** RSA2 **
            'ali_private_key' => $config['pay_alipay_key_path'],
            ], $config);
    }

    /**
     * @param null $type
     * @return \Omnipay\Alipay\AopPageGateway
     */
    public function create($type = null)
    {
        !$type && $type = self::TYPE_PC;

        /* @var $gateway \Omnipay\Alipay\AopPageGateway */
        $gateway = Omnipay::create($type);
        $gateway->setSignType('RSA2');
        $gateway->setAppId($this->config['app_id'] ?? '');
        $gateway->setAlipayPublicKey(Yii::getAlias($this->config['pay_ali_public_key'] ?? ''));
        $gateway->setPrivateKey(Yii::getAlias($this->config['pay_ali_private_key'] ?? ''));
        $gateway->setNotifyUrl($this->config['notify_url']);
        !empty($this->config['return_url']) && $gateway->setReturnUrl($this->config['return_url']);

        return $gateway;
    }

    /**
     * @return \Omnipay\Alipay\Requests\AopCompletePurchaseRequest|\Omnipay\Common\Message\AbstractRequest|\Omnipay\WechatPay\Message\CompletePurchaseResponse
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function notify()
    {
        $gateway = $this->create(self::TYPE_PC);
        $request = $gateway->completePurchase();
        $request->setParams(array_merge(Yii::$app->request->post(), Yii::$app->request->get())); // Optional

        return $request;
    }
}
