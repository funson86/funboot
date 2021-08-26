<?php

namespace common\components\payment;

use yii\base\Component;

/**
 * Class BasePayment
 * @package common\components\payment
 * @author funson86 <funson86@gmail.com>
 */
abstract class BasePayment extends Component
{
    /**
     * @param $config
     * @return mixed
     */
    abstract public function initConfig($config);

    /**
     * @param null $type
     * @return \Omnipay\WechatPay\BaseAbstractGateway
     */
    abstract public function create($type = null);

    /**
     * @return \Omnipay\WechatPay\Message\CompletePurchaseResponse
     */
    abstract public function notify();
}
