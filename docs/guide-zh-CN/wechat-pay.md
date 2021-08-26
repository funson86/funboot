微信支付
------

微信支付的发起是使用EasyWechat组件，接收通知使用Onmipay组件


### 控制器和视图

参考frontend\modules\wechat\controllers\DefaultController.php的actionPay，生成订单后发起

```php
        $orderData = [
            'trade_type' => 'JSAPI', // JSAPI，NATIVE，APP...
            'body' => '支付简单说明',
            'detail' => '支付详情',
            'notify_url' => Yii::$app->urlManager->createAbsoluteUrl(['wechat/notify/wechat']), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'out_trade_no' => $out_trade_no, // 支付
            'total_fee' => $totalFee,
            'openid' => Yii::$app->params['wechat']['userInfo']['id'], // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];

        $payment = Yii::$app->wechat->payment;
        $result = $payment->order->unify($orderData);
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $config = $payment->jssdk->sdkConfig($result['prepay_id']);
        }

        return $this->render($this->action->id, [
            'jssdk' => $payment->jssdk, // $app通过上面的获取实例来获取
            'config' => $config
        ]);

```

view 中代码

### 返回通知

参考

### 通知调试

本地模拟微信支付返回

![](images/wechat-pay-debug.png)
