Funpay
-----------

### 基本配置

在common/config/param.php中配置接收邮件

```php
    'funPay' => [
        'adminEmail' => '3375074@qq.com',
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