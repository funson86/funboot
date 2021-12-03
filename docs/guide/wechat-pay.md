Wechat Pay
------

Wechat pay use EasyWechat component, while notification use Onmipay Component.


### Controller & View

Refer to actionPay in frontend\modules\wechat\controllers\DefaultController.php, after order generated

```php
        $orderData = [
            'trade_type' => 'JSAPI', // JSAPI，NATIVE，APP...
            'body' => 'desc',
            'detail' => 'detail',
            'notify_url' => Yii::$app->urlManager->createAbsoluteUrl(['wechat/notify/wechat']), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'out_trade_no' => $out_trade_no, // order id
            'total_fee' => $totalFee,
            'openid' => Yii::$app->params['wechat']['userInfo']['id'], // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];

        $payment = Yii::$app->wechat->payment;
        $result = $payment->order->unify($orderData);
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $config = $payment->jssdk->sdkConfig($result['prepay_id']);
        }

        return $this->render($this->action->id, [
            'jssdk' => $payment->jssdk,
            'config' => $config
        ]);

```

Code in view file

### Notification


Data in NotifyController

```php
[
    'appid' => 'wx85d219c4f262dbe4',
    'bank_type' => 'CMB_CREDIT',
    'cash_fee' => '1',
    'fee_type' => 'CNY',
    'is_subscribe' => 'Y',
    'mch_id' => '1522368541',
    'nonce_str' => '612627913cba9',
    'openid' => 'oGNvK5rH59h4DD2w2rit9Y5AoYRo',
    'out_trade_no' => '162989044927123541',
    'result_code' => 'SUCCESS',
    'return_code' => 'SUCCESS',
    'sign' => 'B5D812E9ECC9EEACFC4348A755C0B645',
    'time_end' => '20210825192056',
    'total_fee' => '1',
    'trade_type' => 'JSAPI',
    'transaction_id' => '4200001130202108251929622990',
]
```

### Notification Debug

Simulate notification data at debug mode.

![](images/wechat-pay-debug.png)

```xml
<xml>
    <appid><![CDATA[wx85d21ss4f262dbe4]]></appid>
    <bank_type><![CDATA[CMB_CREDIT]]></bank_type>
    <cash_fee><![CDATA[1]]></cash_fee>
    <fee_type><![CDATA[CNY]]></fee_type>
    <is_subscribe><![CDATA[Y]]></is_subscribe>
    <mch_id><![CDATA[1522368541]]></mch_id>
    <nonce_str><![CDATA[612627913cba9]]></nonce_str>
    <openid><![CDATA[oGNvK5rH59h4DD2w2rit9Y5AoYRo]]></openid>
    <out_trade_no><![CDATA[162989044927123541]]></out_trade_no>
    <result_code><![CDATA[SUCCESS]]></result_code>
    <return_code><![CDATA[SUCCESS]]></return_code>
    <sign><![CDATA[B5D812E9ECC9EEACFC4348A755C0B645]]></sign>
    <time_end><![CDATA[20210825192056]]></time_end>
    <total_fee>1</total_fee>
    <trade_type><![CDATA[JSAPI]]></trade_type>
    <transaction_id><![CDATA[4200001130202108251929622990]]></transaction_id>
</xml>
```
