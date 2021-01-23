系统组件
-----------

目录

- AuthSystem RBAC鉴权组件
- LogSystem 日志组件 
- SettingSystem 配置组件
- DictSystem 数据字典组件 
- CacheSystem 缓存组件  
- MailSystem 邮件组件 
- Store 组件 
- Message 消息组件 
- 最佳实践：扩展组件功能或自定义组件

Funboot的所有系统组件以XxxxSystem结尾，配置在common/config/main.php中。代码文件在common/components/base目录下

> 为了方便开发查看在ide_helper.php中增加了跳转


```
        'storeSystem' => [
            'class' => 'common\components\base\StoreSystem',
        ],
        'logSystem' => [
            'class' => 'common\components\base\LogSystem',
            'queue' => false,//true, // 是否通过队列方式存数据库
            'levels' => ['error', 'warning'], // 记录日志等级error warning info trace
            'ignoreCodes' => [404], // 忽略错误码
        ],
        'authSystem' => [
            'class' => 'common\components\base\AuthSystem',
            'superAdminUsernames' => ['admin', 'superadmin'], //拥有所有权限的用户名
            'maxAdminRoleId' => 49, //管理员最大角色ID
            'maxStoreRoleId' => 99, //能进入后台用户最大角色ID
        ],
        'cacheSystem' => [
            'class' => 'common\components\base\CacheSystem',
        ],
        'dictSystem' => [
            'class' => 'common\components\base\DictSystem',
        ],
        'messageSystem' => [
            'class' => 'common\components\base\MessageSystem',
            'queue' => false,//true, // 是否通过队列方式存数据库
        ],
        'settingSystem' => [
            'class' => 'common\components\base\SettingSystem',
        ],
        'mailSystem' => [
            'class' => 'common\components\base\MailSystem',
            'queue' => true, //false, // 默认通过队列方式发送邮件
        ],
        'cacheMall' => [
            'class' => 'common\components\mall\CacheMall',
        ],
```


### AuthSystem RBAC权限控制组件

参见[RBAC权限控制组件](dev-rbac.md)：每个用户对应一个角色，不同角色包含不同权限


### LogSystem 日志组件 

参见[Funboot日志组件](dev-log.md)：后台直接查看指定日志


### SettingSystem 配置组件

配置组件能大大降低系统需要增加配置时的工作量，只需要在数据表中插入数据或者在后台的配置即可生成配置表单

```
INSERT INTO `fb_base_setting_type` VALUES ('46', '1', '0', 'backend', '商品管理', 'product', '', 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('4601', '1', '46', 'backend', '名称前显示SKU', 'product_show_sku', '是否在商品名称前显示sku', 'radioList', '0:否,1:是', '0', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('4603', '1', '46', 'backend', '名称后显示第二语言', 'product_show_local', '是否在商品名称后显示第二语言', 'radioList', '0:否,1:是', '0', '50', '1', '1600948360', '1600948360', '1', '1');
```


每个Store的配置ID是不同的，需要传入code和storeId

```php

Yii::$app->settingSystem->getValue('website_copyright', 1);

// controller中
Yii::$app->settingSystem->getValue('website_copyright', $this->getStoreId());

// view 中
$store = $this->context->store;
echo $store->settings['website_name'] ?: 'Funboot';
```

### DictSystem 数据字典组件 

数据字典主要用来给运营人员使用的，比如已系统开通的城市，在数据字典中添加代码即可

```php
Yii::$app->dictSystem->getDict('open_cities'); //返回 ['open_cities_sz' => '深圳', 'open_cities_sz' => '北京',]
Yii::$app->dictSystem->getDictData('open_cities_sz'); // 返回 '深圳'
```

### CacheSystem 缓存组件 

缓存组件基于Yii2提供的缓存组件，在common/config/main.php中配置



```php
$allDict = Yii::$app->cacheSystem->getAllDict();; // 获取数据字典缓存
Yii::$app->cacheSystem->clearAllPermission(); // 清理缓存
```


### MailSystem 邮件组件 

快速使用smtp方式发送邮件。

```php
Yii::$app->mailSystem->send('funson86@qq.com', '标题：明天有空吗？', '想一起去去公园');
```

需要先配置系统发件箱，修改common\config\params-local.php文件中增加

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


### Store 组件 

获取当前store的相关数据，主要用于不方便使用$ths->getStoreId()的地方

```php
Yii::$app->storeSystem->set($this->store); // 设置store
$storeId = Yii::$app->storeSystem->getId(); // 获取当前store相关信息
```


### Message 消息组件 

主要用于发送消息

```php
Yii::$app->messageSystem->send($model, Yii::$app->user->id);
```


### 最佳实践：扩展组件功能或自定义组件

> 如果觉得系统提供的组件功能不足，可以在common/components/下新建一个目录（可以是自己的公司），可以集成Funboot系统组件或者自定义组件
> 然后修改common/config/main.php中的配置。