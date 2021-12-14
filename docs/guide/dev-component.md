系统组件
-----------

Table of contents

- AuthSystem RBAC Role Based Access Control
- LogSystem Log Component
- SettingSystem Setting Component
- DictSystem Dict Component
- CacheSystem Cache Component
- MailSystem Mail Component
- StoreSystem Store Component
- MessageSystem Message Component
- Best Practice： Expand system component or write your component

All components in Funboot are like XxxxSystem ended with System, configured in common/config/main.php, the code file is in common/components/base directory

> Add to ide_helper.php to prompt in IDE 


```
        'storeSystem' => [
            'class' => 'common\components\base\StoreSystem',
        ],
        'logSystem' => [
            'class' => 'common\components\base\LogSystem',
            'queue' => false,//true, // use queue to save log or not
            'driver' => 'mysql', //'mongodb', // driver, mysql or mongodb
            'levels' => ['error', 'warning'], // level of log: error warning info trace
            'ignoreCodes' => [404], // ignore code of log
        ],
        'authSystem' => [
            'class' => 'common\components\base\AuthSystem',
            'superAdminUsernames' => ['admin', 'superadmin'], // own all permission
            'maxAdminRoleId' => 49, // max role id of admin 
            'maxStoreRoleId' => 99, // max role id for login in backend 
        ],
        'cacheSystem' => [
            'class' => 'common\components\base\CacheSystem',
        ],
        'dictSystem' => [
            'class' => 'common\components\base\DictSystem',
        ],
        'messageSystem' => [
            'class' => 'common\components\base\MessageSystem',
            'queue' => false,//true, // use queue to send or not
        ],
        'settingSystem' => [
            'class' => 'common\components\base\SettingSystem',
        ],
        'mailSystem' => [
            'class' => 'common\components\base\MailSystem',
            'queue' => true, //false, // use queue to send message or not
        ],
        'cacheMall' => [
            'class' => 'common\components\mall\CacheMall',
        ],
```


### AuthSystem RBAC Role Based Access Control

Refer to [RBAC Role Based Access Control](dev-rbac.md)：Each user contain to one role or multiple role, and different roles contain different permissions


### LogSystem Log Component 

Refer to [Funboot Log Component](dev-log.md)：view log in backend


### SettingSystem Setting Component

Setting Component save many workload of add an new config in the backend. only need to add a record in table.

```
INSERT INTO `fb_base_setting_type` VALUES ('46', '1', '0', 'backend', 'Product Management', 'product', '', 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('4601', '1', '46', 'backend', 'Product show sku', 'product_show_sku', 'show sku after name', 'radioList', '0:No,1:Yes', '0', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('4603', '1', '46', 'backend', 'Show local language after name', 'product_show_local', '', 'radioList', '0:No,1:Yes', '0', '50', '1', '1600948360', '1600948360', '1', '1');
```


The build-in function need code and storeId for each store has a different ID.

```php

Yii::$app->settingSystem->getValue('website_copyright', 1);

// in controller
Yii::$app->settingSystem->getValue('website_copyright', $this->getStoreId());

// in view
$store = $this->context->store;
echo $store->settings['website_name'] ?: 'Funboot';
```

### DictSystem Dict Component

Dict data is used for the admin and operator, for example, the supported cities of system, add city code in backend.

```php
Yii::$app->dictSystem->getDict('open_cities'); //return ['open_cities_london' => 'London', 'open_cities_newyork' => 'New York',]
Yii::$app->dictSystem->getDictData('open_cities_sz'); // return  'London'
```

### CacheSystem Cache Component

Cache Component is based on Yii cache, which config in common/config/main.php


```php
$allDict = Yii::$app->cacheSystem->getAllDict();; // Get cache of dict data
Yii::$app->cacheSystem->clearAllPermission(); // clear cache
```


### MailSystem Mail Component

Use smtp to send email conveniently.

```php
Yii::$app->mailSystem->send('funson86@qq.com', 'Are you free tomorrow?', 'I want to go to the park together');
```

Config smtp first, add code in common\config\params-local.php

```php
return [

    //SMTP config
    'smtp_host' => 'smtp.office365.com',
    'smtp_username' => 'funboot@outlook.com',
    'smtp_password' => 'xxx',
    'smtp_port' => '587',
    'smtp_encryption' => 'tls',
];
```

If an html need to be rendered first, use code below in the action of controller
```
$content = CommonHelper::render(Yii::getAlias('@common/mail/mail.php'), [
    'model' => $model,
    'store' => $store,
], $this, Yii::getAlias('@common/mail/layouts/html.php'));
Yii::$app->mailSystem->send('funson86@qq.com', 'Are you free tomorrow?', $content);
```

### StoreSystem Store Component 

Get current store information, while using $this->store and $this->getStoreId() in Controller.

```php
Yii::$app->storeSystem->set($this->store); // set store
$storeId = Yii::$app->storeSystem->getId(); // get store information
```


### MessageSystem Message Component 

Send messages for admin to store owner.

```php
Yii::$app->messageSystem->send($model, Yii::$app->user->id);
```


### Best Practice： Expand system component or write your component

> You can self-define your component by add an directory in common/components/ (eg: function, or your company), may inherit Funboot component.
> then modify the config in common/config/main.php