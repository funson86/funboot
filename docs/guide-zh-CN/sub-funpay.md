Funpay 个人收款支付子系统
-------

> 代码作为样例已集成在[Funboot](https://github.com/funson86/)开发平台中。直接clone Funboot项目即可。

### 在线体验

在线体验网址： https://funpay.funboot.net

### 快速安装

代码作为样例已集成在[Funboot](https://github.com/funson86/)开发平台中。直接clone Funboot项目即可。请参考 Funboot安装文档 https://github.com/funson86/funboot/blob/master/docs/guide-zh-CN/start-installation.md


### 基本配置

在common/config/param.php中配置接收邮件

```php
    'funPay' => [
        'adminEmail' => '3375074@qq.com',
        'adminName' => 'Funson',
    ],
```

在common/config/param-local.php文件中配置邮件相关信息

```php
return [
    'smtp_host' => 'smtp.163.com',
    'smtp_username' => 'funson86@163.com',
    'smtp_password' => '',
    'smtp_port' => '587',
    'smtp_encryption' => 'tls',
];
```

这样才能在支付订单时，给管理员邮箱发邮件


### 定时任务

每日凌晨将待支付的订单变成忘了支付的。在系统的定时任务中默认已有，手动执行如下：

```
php yii funpay/order-expire
```

### 参考

- http://github.com/funson86/funpay
