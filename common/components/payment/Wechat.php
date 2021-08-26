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
class Wechat extends BasePayment
{
    const TYPE_DEFAULT = 'WechatPay';
    const TYPE_APP = 'WechatPay_App';
    const TYPE_NATIVE = 'WechatPay_Native';
    const TYPE_JS = 'WechatPay_Js';
    const TYPE_POS = 'WechatPay_Pos';
    const TYPE_MWEB = 'WechatPay_Mweb';

    public $config;

    public function initConfig($config)
    {
        $this->config = ArrayHelper::merge([
            'app_id' => $config['wechat_appid'], // 公众号 APPID
            'open_app_id' => $config['pay_wechat_open_appid'], // 微信开放平台 APPID
            //'mini_program_app_id' => $config['miniprogram_appid'], // 微信小程序 APPID
            'mch_id' => $config['pay_wechat_mchid'],
            'api_key' => $config['pay_wechat_api_key'],
            'cert_client' => $config['pay_wechat_cert_path'], // optional，退款等情况时用到
            'cert_key' => $config['pay_wechat_key_path'],// optional，退款等情况时用到
            ], $config);
    }

    /**
     * @param null $type
     * @return \Omnipay\WechatPay\AppGateway
     */
    public function create($type = null)
    {
        !$type && $type = self::TYPE_DEFAULT;

        /* @var $gateway \Omnipay\WechatPay\AppGateway */
        $gateway = Omnipay::create($type);
        $gateway->setMchId($this->config['mch_id'] ?? '');
        $gateway->setApiKey($this->config['api_key'] ?? '');
        $gateway->setCertPath(Yii::getAlias($this->config['cert_client'] ?? ''));
        $gateway->setKeyPath(Yii::getAlias($this->config['cert_key'] ?? ''));

        $gateway->setAppId($this->config[$type == self::TYPE_APP ? 'open_app_id' : 'app_id']);

        // 兼容EasyWechat
        if ($type === self::TYPE_JS) {
            Yii::$app->params['wechatPaymentConfig'] = ArrayHelper::merge(Yii::$app->params['wechatPaymentConfig'], [
                'app_id' => $this->config['app_id'],
                'mch_id' => $this->config['mch_id'],
                'key' => $this->config['api_key'],
                'cert_path' => Yii::getAlias($this->config['cert_client']),
                'key_path' => Yii::getAlias($this->config['cert_key']),
            ]);
        }

        return $gateway;
    }

    /**
     * @return \Omnipay\WechatPay\Message\CompletePurchaseResponse
     */
    public function notify()
    {
        $gateway = $this->create(self::TYPE_DEFAULT);

        return $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();

    }
}
