Funpay Payment Subsystem
-------

> The code is integrated in [Funboot](https://github.com/funson86/funboot), clone Funboot to get the code.

### Demo

Demo: https://funpay.funboot.net

### Installation

Refer to Funboot Installation https://github.com/funson86/funboot/blob/master/docs/guide-zh-CN/start-installation.md


### Config

Config admin email in common/config/param.php to receive note email

```php
    'funPay' => [
        'adminEmail' => '3375074@qq.com',
        'adminName' => 'Funson',
    ],
```

Config smtp info in common/config/param-local.php

```php
return [
    'smtp_host' => 'smtp.163.com',
    'smtp_username' => 'funson86@163.com',
    'smtp_password' => '',
    'smtp_port' => '587',
    'smtp_encryption' => 'tls',
];
```

If some order paid in system, the admin will receive an notificaiton email.


### Schedule

Change the unpaid order to forgotten order in the monring every day in Schedule Admin in the backend. Or run command manually 

```
php yii funpay/order-expire
```

### References

- http://github.com/funson86/funpay
